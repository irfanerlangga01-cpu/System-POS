@extends('layout.main')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('main-content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1" style="opacity: 0.9;">Total Pendapatan</p>
                    <h2 class="mb-0 fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    <small style="opacity: 0.8;">Tahun {{ date('Y') }}</small>
                </div>
                <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-wallet" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #22C55E 0%, #4ADE80 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1" style="opacity: 0.9;">Transaksi Hari Ini</p>
                    <h2 class="mb-0 fw-bold">Rp {{ number_format($transaksiHariIni, 0, ',', '.') }}</h2>
                    <small style="opacity: 0.8;"><i class="fas fa-arrow-up me-1"></i>{{ $totalTransaksi }} total</small>
                </div>
                <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-receipt" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #FACC15 0%, #FDE047 100%); color: #1E293B;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1" style="opacity: 0.9;">Total Barang</p>
                    <h2 class="mb-0 fw-bold">{{ $totalBarang }}</h2>
                    <small style="opacity: 0.8;">{{ $totalKategori }} kategori</small>
                </div>
                <div style="width: 60px; height: 60px; background: rgba(0,0,0,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-boxes-stacked" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="mb-1" style="opacity: 0.9;">Total Stok</p>
                    <h2 class="mb-0 fw-bold">{{ number_format($totalStok, 0, ',', '.') }}</h2>
                    @if($barangRendah > 0)
                    <small style="opacity: 0.8;"><i class="fas fa-exclamation-triangle me-1"></i>{{ $barangRendah }} rendah</small>
                    @else
                    <small style="opacity: 0.8;">semua aman</small>
                    @endif
                </div>
                <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-warehouse" style="font-size: 28px;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-chart-line me-2"></i>Grafik Penjualan {{ date('Y') }}</h5>
                <span class="badge bg-danger rounded-pill">Tahun Ini</span>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="120" style="background: rgba(255,255,255,0.7); border-radius: 12px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-chart-pie me-2"></i>Statistik</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Barang</span>
                        <span class="fw-bold">{{ $totalBarang }}</span>
                    </div>
                    <div class="progress" style="height: 8px; border-radius: 4px;">
                        <div class="progress-bar" style="width: 70%; background: #2563EB;"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Kategori</span>
                        <span class="fw-bold">{{ $totalKategori }}</span>
                    </div>
                    <div class="progress" style="height: 8px; border-radius: 4px;">
                        <div class="progress-bar" style="width: 50%; background: #FACC15;"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Transaksi</span>
                        <span class="fw-bold">{{ $totalTransaksi }}</span>
                    </div>
                    <div class="progress" style="height: 8px; border-radius: 4px;">
                        <div class="progress-bar" style="width: 90%; background: #22C55E;"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Stok Rendah</span>
                        <span class="fw-bold" style="color: #DC2626;">{{ $barangRendah }}</span>
                    </div>
                    <div class="progress" style="height: 8px; border-radius: 4px;">
                        <div class="progress-bar" style="width: {{ $barangRendah > 0 ? 30 : 100 }}%; background: {{ $barangRendah > 0 ? '#DC2626' : '#22C55E' }};"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-clock me-2"></i>Transaksi Terakhir</h5>
                <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $t)
                            <tr>
                                <td class="fw-bold">{{ $t->kode_transaksi }}</td>
                                <td>{{ date('d/m/Y', strtotime($t->tanggal)) }}</td>
                                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Stok Menipis</h5>
                <a href="{{ route('barang.stokrendah') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokRendah as $b)
                            <tr>
                                <td class="fw-bold">{{ $b->kode_barang }}</td>
                                <td>{{ $b->nama_barang }}</td>
                                <td class="fw-bold text-danger">{{ $b->stok }}</td>
                                <td><span class="stok-rendah">Habis</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(37, 99, 235, 0.5)');
gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Pendapatan',
            data: @json($chartData),
            backgroundColor: gradient,
            borderColor: '#2563EB',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#2563EB',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1E293B',
                titleColor: '#fff',
                bodyColor: '#fff',
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { color: '#64748B', font: { size: 12 } }
            },
            y: {
                grid: { color: '#E2E8F0' },
                ticks: { 
                    color: '#64748B',
                    callback: function(value) {
                        if(value >= 1000000) return 'Rp ' + (value/1000000).toFixed(0) + 'JT';
                        if(value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'K';
                        return 'Rp ' + value;
                    }
                }
            }
        }
    }
});
</script>
@endsection