<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\ActivityLog;
use App\Models\Saldo;
use App\Models\Piutang;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LaporanController extends Controller
{
    public function index()
    {
        $bulan = (int) date('n');
        $tahun = (int) date('Y');
        
        $saldos = Saldo::orderBy('created_at', 'asc')->get();
            
        $barangs = Barang::orderBy('stok', 'asc')->get();
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->limit(50)->get();
        
        $piutangs = Piutang::orderBy('created_at', 'desc')->get();
        $totalPiutang = $piutangs->where('status', 'belum_lunas')->sum('jumlah');

        $totalSaldoSeluruhPeriode = $this->hitungTotalSeluruhPeriode();
        $saldoTersedia = $this->ambilSaldoTersedia();
        
        return view('laporan.index', compact('barangs', 'logs', 'saldos', 'piutangs', 'totalPiutang', 'bulan', 'tahun', 'totalSaldoSeluruhPeriode', 'saldoTersedia'));
    }

    private function hitungTotalSeluruhPeriode()
    {
        $totalDebit = (float) Saldo::where('jenis', 'debit')->sum('nominal');
        $totalKredit = (float) Saldo::where('jenis', 'kredit')->sum('nominal');

        return $totalDebit - $totalKredit;
    }

    private function ambilSaldoTersedia()
    {
        $lastSaldo = Saldo::orderBy('id', 'desc')->first();

        return $lastSaldo ? (float) $lastSaldo->saldo : 0.0;
    }

    public function kelolaSaldoOwner(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:pemasukan,keluar',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $nominal = (float) $request->nominal;
                $lastSaldo = Saldo::orderBy('id', 'desc')->lockForUpdate()->first();
                $saldoSekarang = $lastSaldo ? (float) $lastSaldo->saldo : 0.0;

                if ($request->tipe === 'pemasukan') {
                    $jenis = 'debit';
                    $saldoSekarang += $nominal;
                    $kategori = 'Pemasukan dari Owner';
                } else {
                    if ($nominal > $saldoSekarang) {
                        throw ValidationException::withMessages([
                            'nominal' => 'Saldo tidak cukup. Saldo tersedia: Rp ' . number_format($saldoSekarang, 0, ',', '.'),
                        ]);
                    }

                    $jenis = 'kredit';
                    $saldoSekarang -= $nominal;
                    $kategori = 'Saldo Keluar ke Owner';
                }

                $keterangan = $request->keterangan ?: $kategori;

                Saldo::create([
                    'aktifitas' => $keterangan,
                    'jenis' => $jenis,
                    'nominal' => $nominal,
                    'saldo' => $saldoSekarang,
                ]);

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'aksi' => $kategori,
                    'detail' => $keterangan . ' - Rp ' . number_format($nominal, 0, ',', '.'),
                ]);
            });

            return response()->json([
                'message' => 'Saldo owner berhasil dicatat',
                'total_saldo' => $this->hitungTotalSeluruhPeriode(),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => collect($e->errors())->flatten()->first(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mencatat saldo owner: ' . $e->getMessage()], 422);
        }
    }

    public function laporanSaldo(Request $request)
    {
        $query = Saldo::orderBy('created_at', 'asc');

        if ($request->bulan && $request->tahun) {
            $query->whereYear('created_at', $request->tahun)
                  ->whereMonth('created_at', $request->bulan);
        }

        $saldos = $query->get();
        return response()->json($saldos);
    }

    public function laporanPenjualan(Request $request)
    {
        $query = Transaksi::with('user');

        if ($request->bulan && $request->tahun) {
            $query->whereYear('tanggal', $request->tahun)
                  ->whereMonth('tanggal', $request->bulan);
        }

        $transaksis = $query->orderBy('tanggal', 'desc')->get();
        $totalPendapatan = $transaksis->sum('total');

        return response()->json([
            'transaksis' => $transaksis,
            'totalPendapatan' => $totalPendapatan,
        ]);
    }

    public function laporanStok(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->stok_rendah == 'true') {
            $query->where('stok', '<', 10);
        }

        $barangs = $query->orderBy('stok', 'asc')->get();
        $totalStok = $barangs->sum('stok');

        return response()->json([
            'barangs' => $barangs,
            'totalStok' => $totalStok,
        ]);
    }

    public function grafikPenjualan(Request $request)
    {
        $query = Transaksi::select(
            DB::raw("DATE_FORMAT(tanggal, '%m') as bulan"),
            DB::raw('SUM(total) as total')
        );

        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $data = $query->groupBy('bulan')->orderBy('bulan')->get();

        $chartData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $chartData[(int)$item->bulan - 1] = (float) $item->total;
        }

        return response()->json($chartData);
    }

    public function produkTerlaris(Request $request)
    {
        $query = DetailTransaksi::select(
            'barang_id',
            DB::raw('SUM(qty) as total_qty'),
            DB::raw('SUM(subtotal) as total_subtotal')
        )->with('barang');

        if ($request->tahun) {
            $query->whereHas('transaksi', function($q) use ($request) {
                $q->whereYear('tanggal', $request->tahun);
            });
        }

        $data = $query->groupBy('barang_id')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    public function laporanPiutang(Request $request)
    {
        $query = Piutang::orderBy('created_at', 'desc');

        if ($request->bulan && $request->tahun) {
            $query->whereYear('tanggal', $request->tahun)
                ->whereMonth('tanggal', $request->bulan);
        } elseif ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        return response()->json(
            $query->get(['id', 'no_member', 'nama_pelanggan', 'no_hp', 'jumlah', 'status', 'tanggal'])
        );
    }

    public function laporanRiwayat(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');

        if ($request->bulan && $request->tahun) {
            $query->whereYear('created_at', $request->tahun)
                ->whereMonth('created_at', $request->bulan);
        } elseif ($request->tahun) {
            $query->whereYear('created_at', $request->tahun);
        }

        return response()->json($query->get());
    }

    public function bayarPiutang(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:piutangs,id',
            'jumlah_bayar' => 'nullable|numeric|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $piutang = Piutang::findOrFail($request->id);
                $jumlahBayar = $request->jumlah_bayar ? (int) $request->jumlah_bayar : $piutang->jumlah;

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

            return response()->json(['message' => 'Piutang berhasil dilunasi']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}