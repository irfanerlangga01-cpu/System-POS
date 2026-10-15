<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
        \DB::table('users')->where('id', $admin->id)->update(['role' => 'admin']);

        $karyawan = User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        \DB::table('users')->where('id', $karyawan->id)->update(['role' => 'karyawan']);

        $kategoris = [
            ['nama_kategori' => 'Alat Tulis'],
            ['nama_kategori' => 'Kertas'],
            ['nama_kategori' => 'Buku'],
            ['nama_kategori' => 'Penghapus'],
            ['nama_kategori' => 'Pena'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        $barangs = [
            ['kode_barang' => 'ATK001', 'nama_barang' => 'Pensil 2B', 'kategori_id' => 1, 'harga' => 3000, 'stok' => 100],
            ['kode_barang' => 'ATK002', 'nama_barang' => 'Ballpoint Hitam', 'kategori_id' => 5, 'harga' => 2500, 'stok' => 150],
            ['kode_barang' => 'ATK003', 'nama_barang' => 'Pulpen Biru', 'kategori_id' => 5, 'harga' => 2000, 'stok' => 80],
            ['kode_barang' => 'ATK004', 'nama_barang' => 'Penghapus', 'kategori_id' => 4, 'harga' => 1500, 'stok' => 50],
            ['kode_barang' => 'ATK005', 'nama_barang' => 'Penggaris 30cm', 'kategori_id' => 1, 'harga' => 5000, 'stok' => 30],
            ['kode_barang' => 'ATK006', 'nama_barang' => 'Kertas A4', 'kategori_id' => 2, 'harga' => 35000, 'stok' => 25],
            ['kode_barang' => 'ATK007', 'nama_barang' => 'Kertas Folio', 'kategori_id' => 2, 'harga' => 20000, 'stok' => 8],
            ['kode_barang' => 'ATK008', 'nama_barang' => 'Buku Tulis', 'kategori_id' => 3, 'harga' => 5000, 'stok' => 60],
            ['kode_barang' => 'ATK009', 'nama_barang' => 'Stapler', 'kategori_id' => 1, 'harga' => 15000, 'stok' => 15],
            ['kode_barang' => 'ATK010', 'nama_barang' => 'Isi Stapler', 'kategori_id' => 1, 'harga' => 5000, 'stok' => 5],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}