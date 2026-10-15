<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\ActivityLog;
use App\Models\Saldo;
use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $tanggal = request('tanggal', date('Y-m-d'));
        
        if ($tanggal) {
            $transaksis = Transaksi::with(['user', 'detailTransaksi', 'piutangs'])
                ->whereDate('tanggal', $tanggal)
                ->orderBy('tanggal', 'desc')
                ->get();
        } else {
            $transaksis = Transaksi::with(['user', 'detailTransaksi', 'piutangs'])
                ->orderBy('tanggal', 'desc')
                ->limit(100)
                ->get();
        }
        
        $logs = ActivityLog::where('aksi', 'Transaksi')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        
        return view('transaksi.index', compact('transaksis', 'tanggal', 'logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'array',
            'items.*.barang_id' => 'required_with:items|exists:barang,id',
            'items.*.qty' => 'required_with:items|integer|min:1',
            'piutang_items' => 'array',
            'piutang_items.*.piutang_ids' => 'required_with:piutang_items|array',
            'piutang_items.*.total' => 'required_with:piutang_items|numeric|min:0',
            'tipe_pembayaran' => ['nullable', 'in:bayar,hutang'],
            'no_member' => ['nullable', 'integer'],
            'nama_pelanggan' => ['required_if:tipe_pembayaran,hutang', 'nullable', 'string'],
            'no_hp' => ['required_if:tipe_pembayaran,hutang', 'nullable', 'string'],
        ]);

        $items = $request->items ?? [];
        $piutangItems = $request->piutang_items ?? [];

        if (empty($items) && empty($piutangItems)) {
            return response()->json(['message' => 'Keranjang masih kosong'], 422);
        }

        try {
            $transaksi = null;
            DB::transaction(function () use ($request, $items, $piutangItems, &$transaksi) {
                $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . str_pad(Transaksi::count() + 1, 4, '0', STR_PAD_LEFT);
                $total = 0;

                $transaksi = Transaksi::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'tanggal' => date('Y-m-d H:i:s'),
                    'total' => 0,
                    'user_id' => Auth::id(),
                ]);

                foreach ($items as $item) {
                    $barang = Barang::findOrFail($item['barang_id']);
                    $subtotal = $barang->harga * $item['qty'];
                    $total += $subtotal;

                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'barang_id' => $barang->id,
                        'qty' => $item['qty'],
                        'harga' => $barang->harga,
                        'subtotal' => $subtotal,
                    ]);

                    $barang->decrement('stok', $item['qty']);
                }

                $isHutang = $request->tipe_pembayaran === 'hutang';
                $piutangTotal = 0;

                foreach ($piutangItems as $piutangItem) {
                    $piutangIds = array_map('intval', $piutangItem['piutang_ids']);
                    $itemTotal = $piutangItem['total'];
                    $piutangTotal += $itemTotal;

                    if (!empty($piutangIds)) {
                        $paidPiutang = Piutang::whereIn('id', $piutangIds)->where('status', 'belum_lunas')->first();

                        Piutang::whereIn('id', $piutangIds)->where('status', 'belum_lunas')->update([
                            'status' => 'lunas',
                            'jumlah' => 0,
                            'transaksi_id' => $transaksi->id,
                        ]);

                        if ($itemTotal > 0 && $paidPiutang) {
                            $lastSaldo = Saldo::orderBy('id', 'desc')->first();
                            $saldoSekarang = $lastSaldo ? $lastSaldo->saldo + $itemTotal : $itemTotal;

                            Saldo::create([
                                'aktifitas' => 'Bayar Piutang: ' . $paidPiutang->nama_pelanggan,
                                'jenis' => 'debit',
                                'nominal' => $itemTotal,
                                'saldo' => $saldoSekarang,
                            ]);
                        }
                    }
                }

                $grandTotal = $total + $piutangTotal;
                $transaksi->update(['total' => $grandTotal]);

                if (!$isHutang && $total > 0) {
                    $lastSaldo = Saldo::orderBy('id', 'desc')->first();
                    $saldoSekarang = $lastSaldo ? $lastSaldo->saldo + $total : $total;

                    Saldo::create([
                        'aktifitas' => 'Transaksi: ' . $kodeTransaksi,
                        'jenis' => 'debit',
                        'nominal' => $total,
                        'saldo' => $saldoSekarang,
                    ]);
                } elseif ($isHutang && $total > 0) {
                    Piutang::create([
                        'transaksi_id' => $transaksi->id,
                        'no_member' => $this->resolveNoMember($request),
                        'nama_pelanggan' => $request->nama_pelanggan,
                        'no_hp' => $request->no_hp,
                        'jumlah' => $total,
                        'status' => 'belum_lunas',
                        'tanggal' => date('Y-m-d'),
                    ]);
                }

                $detailLog = 'Transaksi ' . $kodeTransaksi . ' - Rp ' . number_format($grandTotal, 0, ',', '.');
                if ($piutangTotal > 0) {
                    $detailLog .= ' (Bayar Hutang: Rp ' . number_format($piutangTotal, 0, ',', '.') . ')';
                }
                if ($isHutang) {
                    $detailLog .= ' (Hutang)';
                }

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'aksi' => 'Transaksi',
                    'detail' => $detailLog,
                ]);
            });

            return response()->json(['message' => 'Transaksi berhasil disimpan', 'transaksi_id' => $transaksi->id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Transaksi gagal: ' . $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksi.barang', 'piutangs'])->findOrFail($id);
        return view('transaksi.detail', compact('transaksi'));
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksi.barang', 'piutangs'])->findOrFail($id);
        return view('transaksi.print', compact('transaksi'));
    }

    public function getTransaksi()
    {
        $transaksis = Transaksi::with('user')->orderBy('id', 'desc')->get();
        return response()->json($transaksis);
    }

    public function getPiutang()
    {
        $piutangs = Piutang::where('status', 'belum_lunas')->orderBy('created_at', 'desc')->get();
        return response()->json($piutangs);
    }

    public function searchBarang(Request $request)
    {
        $query = trim($request->q ?? '');

        $barangs = Barang::where('stok', '>', 0)
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('kode_barang', 'like', "%{$query}%")
                        ->orWhere('nama_barang', 'like', "%{$query}%");
                });
            })
            ->orderBy('nama_barang')
            ->limit(50)
            ->get(['id', 'kode_barang', 'nama_barang', 'harga', 'stok', 'satuan']);

        return response()->json($barangs);
    }

    public function searchMember(Request $request)
    {
        $query = trim($request->q ?? '');

        $members = Piutang::whereNotNull('no_member')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('no_member', 'like', "%{$query}%")
                        ->orWhere('nama_pelanggan', 'like', "%{$query}%")
                        ->orWhere('no_hp', 'like', "%{$query}%");
                });
            })
            ->orderBy('no_member', 'desc')
            ->get(['no_member', 'nama_pelanggan', 'no_hp'])
            ->groupBy('no_member')
            ->map(fn ($group) => $group->first())
            ->values();

        return response()->json($members);
    }

    protected function resolveNoMember(Request $request): int
    {
        $provided = $request->filled('no_member') ? (int) $request->input('no_member') : 0;
        if ($provided > 0 && Piutang::where('no_member', $provided)->exists()) {
            return $provided;
        }

        $byNameHp = Piutang::whereNotNull('no_member')
            ->where('nama_pelanggan', $request->input('nama_pelanggan'))
            ->where('no_hp', $request->input('no_hp'))
            ->value('no_member');
        if ($byNameHp) {
            return (int) $byNameHp;
        }

        $max = Piutang::whereNotNull('no_member')->max('no_member');
        return $max ? $max + 1 : 9901;
    }

    public function searchPiutang(Request $request)
    {
        $request->validate(['q' => 'required|string|min:1']);
        
        $query = $request->q;
        $piutangs = Piutang::where('status', 'belum_lunas')
            ->where(function ($q) use ($query) {
                $q->where('nama_pelanggan', 'like', "%{$query}%")
                  ->orWhere('no_hp', 'like', "%{$query}%")
                  ->orWhere('no_member', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('nama_pelanggan');

        $results = [];
        foreach ($piutangs as $nama => $items) {
            $results[] = [
                'nama_pelanggan' => $nama,
                'no_member' => $items->first()->no_member ?? null,
                'no_hp' => $items->first()->no_hp,
                'total_hutang' => $items->sum('jumlah'),
                'piutangs' => $items->map(fn($p) => [
                    'id' => $p->id,
                    'jumlah' => $p->jumlah,
                    'tanggal' => $p->tanggal->format('d-m-Y'),
                ]),
            ];
        }

        return response()->json($results);
    }

    public function bayarPiutang(Request $request)
    {
        $request->validate([
            'piutang_id' => 'required|exists:piutangs,id',
            'jumlah_bayar' => 'required|numeric|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $piutang = Piutang::findOrFail($request->piutang_id);
                $jumlahBayar = (int) $request->jumlah_bayar;

                if ($jumlahBayar > $piutang->jumlah) {
                    throw new \Exception('Jumlah bayar tidak boleh melebihi sisa hutang');
                }

                if ($jumlahBayar >= $piutang->jumlah) {
                    $piutang->update(['status' => 'lunas', 'jumlah' => 0]);
                } else {
                    $piutang->update(['jumlah' => $piutang->jumlah - $jumlahBayar]);
                }

                $lastSaldo = Saldo::orderBy('id', 'desc')->first();
                $saldoSekarang = $lastSaldo ? $lastSaldo->saldo + $jumlahBayar : $jumlahBayar;

                Saldo::create([
                    'aktifitas' => 'Bayar Piutang: ' . $piutang->nama_pelanggan,
                    'jenis' => 'debit',
                    'nominal' => $jumlahBayar,
                    'saldo' => $saldoSekarang,
                ]);

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'aksi' => 'Bayar Hutang',
                    'detail' => 'Melunasi hutang: ' . $piutang->nama_pelanggan . ' - Rp ' . number_format($jumlahBayar, 0, ',', '.'),
                ]);
            });

            return response()->json(['message' => 'Hutang berhasil dilunasi']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}