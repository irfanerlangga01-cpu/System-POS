<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\ActivityLog;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->orderBy('id', 'desc')->get();
        $kategoris = Kategori::all();
        $logs = ActivityLog::whereIn('aksi', ['Tambah Barang', 'Ubah Harga', 'Hapus Barang'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return view('barang.index', compact('barangs', 'kategoris', 'logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $hargaModal = (int) ($request->harga_modal ?: ($request->harga ?: 0));
        $totalBiaya = $hargaModal * $request->stok;

        $barang = Barang::create($request->all());

        if ($totalBiaya > 0) {
            $lastSaldo = Saldo::orderBy('id', 'desc')->first();
            $saldoSekarang = $lastSaldo ? $lastSaldo->saldo - $totalBiaya : -$totalBiaya;

            Saldo::create([
                'aktifitas' => 'Tambah Barang: ' . $barang->nama_barang . ' (' . $request->stok . ' unit)',
                'jenis' => 'kredit',
                'nominal' => $totalBiaya,
                'saldo' => $saldoSekarang,
            ]);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Tambah Barang',
            'detail' => 'Menambahkan barang: ' . $barang->nama_barang . ' (Stok: ' . $request->stok . ')',
        ]);

        return response()->json(['message' => 'Barang berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $oldHarga = $barang->harga;
        $oldHargaModal = $barang->harga_modal;

        $barang->update([
            'harga' => $request->harga,
            'harga_modal' => $request->harga_modal ?? $barang->harga_modal,
        ]);

        $changes = [];
        if ($oldHarga != $barang->harga) {
            $changes[] = 'Harga Jual: Rp ' . number_format($oldHarga, 0, ',', '.') . ' → Rp ' . number_format($barang->harga, 0, ',', '.');
        }
        if ($oldHargaModal != $barang->harga_modal) {
            $changes[] = 'Harga Modal: Rp ' . number_format($oldHargaModal, 0, ',', '.') . ' → Rp ' . number_format($barang->harga_modal, 0, ',', '.');
        }

        if (!empty($changes)) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Harga',
                'detail' => $barang->nama_barang . ': ' . implode(', ', $changes),
            ]);
        }

        return response()->json(['message' => 'Harga berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $namaBarang = $barang->nama_barang;
        $barang->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Hapus Barang',
            'detail' => 'Menghapus barang: ' . $namaBarang,
        ]);

        return response()->json(['message' => 'Barang berhasil dihapus']);
    }

    public function getBarang()
    {
        $barangs = Barang::with('kategori')->get();
        return response()->json($barangs);
    }

    public function getStokRendah()
    {
        $barangs = Barang::with('kategori')->orderBy('stok', 'asc')->get();
        $logs = ActivityLog::where('aksi', 'Tambah Stok')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return view('barang.stok', compact('barangs', 'logs'));
    }

    public function restock(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $jumlah = (int) $request->jumlah;
        $barang->increment('stok', $jumlah);

        $hargaModal = (int) ($request->harga_modal
            ?: ($barang->harga_modal
                ?: ($barang->harga ?: 0)));
        $totalBiaya = $hargaModal * $jumlah;

        if ($request->harga_modal) {
            $barang->harga_modal = $request->harga_modal;
        }
        if ($request->harga) {
            $barang->harga = $request->harga;
        }
        $barang->save();

        $lastSaldo = Saldo::orderBy('id', 'desc')->first();
        $saldoSekarang = $lastSaldo ? $lastSaldo->saldo - $totalBiaya : -$totalBiaya;

        Saldo::create([
            'aktifitas' => 'Restok: ' . $barang->nama_barang . ' (' . $jumlah . ' unit)',
            'jenis' => 'kredit',
            'nominal' => $totalBiaya,
            'saldo' => $saldoSekarang,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Tambah Stok',
            'detail' => 'Menambahkan stok ' . $barang->nama_barang . ' +' . $jumlah . ' (Harga Modal: ' . $hargaModal . ', Total: ' . $totalBiaya . ')',
        ]);

        return response()->json(['message' => 'Stok berhasil ditambahkan: +' . $jumlah]);
    }
}