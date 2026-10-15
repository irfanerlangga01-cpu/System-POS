<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AkunController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/barang/data', [BarangController::class, 'getBarang'])->name('barang.data');
    Route::post('/barang/restock', [BarangController::class, 'restock'])->name('barang.restock');
    Route::get('/stok-rendah', [BarangController::class, 'getStokRendah'])->name('barang.stokrendah');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/data', [TransaksiController::class, 'getTransaksi'])->name('transaksi.data');
    Route::get('/transaksi/barang/search', [TransaksiController::class, 'searchBarang'])->name('transaksi.barang.search');
    Route::get('/transaksi/piutang', [TransaksiController::class, 'getPiutang'])->name('transaksi.piutang');
    Route::get('/transaksi/piutang/search', [TransaksiController::class, 'searchPiutang'])->name('transaksi.piutang.search');
    Route::get('/transaksi/member/search', [TransaksiController::class, 'searchMember'])->name('transaksi.member.search');
    Route::post('/transaksi/piutang/bayar', [TransaksiController::class, 'bayarPiutang'])->name('transaksi.piutang.bayar');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/grafik', [LaporanController::class, 'grafikPenjualan'])->name('laporan.grafik');
    Route::get('/laporan/saldo', [LaporanController::class, 'laporanSaldo'])->name('laporan.saldo');
    Route::post('/laporan/saldo-owner', [LaporanController::class, 'kelolaSaldoOwner'])->name('laporan.saldo-owner');
    Route::get('/laporan/produk-terlaris', [LaporanController::class, 'produkTerlaris'])->name('laporan.produk-terlaris');
    Route::get('/laporan/piutang', [LaporanController::class, 'laporanPiutang'])->name('laporan.piutang.data');
    Route::get('/laporan/riwayat', [LaporanController::class, 'laporanRiwayat'])->name('laporan.riwayat');
    Route::post('/laporan/piutang/bayar', [LaporanController::class, 'bayarPiutang'])->name('laporan.piutang.bayar');

    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');
    Route::post('/akun/profil', [AkunController::class, 'updateProfile'])->name('akun.profil');
});