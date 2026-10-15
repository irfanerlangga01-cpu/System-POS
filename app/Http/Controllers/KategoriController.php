<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::with(['barang', 'barang.kategori'])->orderBy('id', 'desc')->get();
        $logs = ActivityLog::whereIn('aksi', ['Tambah Kategori', 'Ubah Kategori', 'Hapus Kategori'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return view('kategori.index', compact('kategoris', 'logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori',
        ]);

        Kategori::create($request->all());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Tambah Kategori',
            'detail' => 'Menambahkan kategori: ' . $request->nama_kategori,
        ]);

        return response()->json(['message' => 'Kategori berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $id,
        ]);

        $oldName = $kategori->nama_kategori;
        $kategori->update($request->all());

        if ($oldName != $kategori->nama_kategori) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Kategori',
                'detail' => 'Mengubah kategori: ' . $oldName . ' → ' . $kategori->nama_kategori,
            ]);
        }

        return response()->json(['message' => 'Kategori berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        if ($kategori->barang()->count() > 0) {
            return response()->json(['message' => 'Tidak dapat menghapus kategori yang memiliki barang'], 422);
        }
        
        $kategori->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Hapus Kategori',
            'detail' => 'Menghapus kategori: ' . $kategori->nama_kategori,
        ]);

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }
}