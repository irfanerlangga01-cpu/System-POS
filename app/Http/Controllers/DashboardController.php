<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total');
        
        $barangRendah = Barang::where('stok', '<', 10)->count();
        $totalKategori = Kategori::count();

        $transaksiHariIni = Transaksi::whereDate('tanggal', date('Y-m-d'))->sum('total');
        
        $penjualanPerBulan = Transaksi::select(
            DB::raw("DATE_FORMAT(tanggal, '%m') as bulan"),
            DB::raw('SUM(total) as total')
        )
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $chartData = array_fill(0, 12, 0);
        foreach ($penjualanPerBulan as $data) {
            $chartData[(int)$data->bulan - 1] = (float) $data->total;
        }

        $recentTransactions = Transaksi::with('user')->orderBy('tanggal', 'desc')->limit(5)->get();
        $topBarang = DetailTransaksi::select('barang_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('barang_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $barang = Barang::find($item->barang_id);
                $item->nama_barang = $barang ? $barang->nama_barang : 'Unknown';
                return $item;
            });
        
        $stokRendah = Barang::where('stok', '<', 10)->orderBy('stok', 'asc')->limit(5)->get();

        return view('dashboard', compact(
            'totalBarang', 'totalStok', 'totalTransaksi', 'totalPendapatan', 
            'chartData', 'barangRendah', 'totalKategori', 'transaksiHariIni',
            'recentTransactions', 'topBarang', 'stokRendah'
        ));
    }
}