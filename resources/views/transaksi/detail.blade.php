@extends('layout.main')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('main-content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary"><i class="fas fa-receipt me-2"></i>Detail Transaksi</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('transaksi.cetak', $transaksi->id) }}" target="_blank" class="btn btn-primary" id="btnCetak">
                <i class="fas fa-print me-2"></i>Cetak
            </a>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <p class="mb-1"><span class="fw-bold">Kode Transaksi:</span> {{ $transaksi->kode_transaksi }}</p>
                <p class="mb-1"><span class="fw-bold">Tanggal:</span> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y H:i') }}</p>
                <p class="mb-1"><span class="fw-bold">Kasir:</span> {{ $transaksi->user->name ?? '-' }}</p>
            </div>
            <div class="col-md-6 text-end">
                <h4 class="text-primary">Total: Rp {{ number_format($transaksi->total, 0, ',', '.') }}</h4>
                @if($transaksi->piutangs->contains('status', 'belum_lunas'))
                    <span class="badge bg-warning fs-6 mt-2">Hutang</span>
                    <a href="{{ route('transaksi.index') }}?bayar_piutang={{ $transaksi->piutangs->firstWhere('status', 'belum_lunas')->id }}" class="btn btn-danger mt-2 ms-2">
                        <i class="fas fa-hand-holding-usd me-2"></i>Bayar Hutang
                    </a>
                @elseif($transaksi->piutangs->isNotEmpty())
                    <span class="badge bg-success fs-6 mt-2">Bayar Hutang</span>
                @else
                    <span class="badge bg-primary fs-6 mt-2">Bayar</span>
                @endif
            </div>
        </div>

        @if($transaksi->piutangs->contains('status', 'belum_lunas'))
        @php $hutang = $transaksi->piutangs->firstWhere('status', 'belum_lunas'); @endphp
        <div class="alert alert-warning">
            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Data Hutang</h6>
            <div class="row">
                <div class="col-md-3">
                    <p class="mb-1"><span class="fw-medium">No. Member:</span><br>{{ $hutang->no_member ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><span class="fw-medium">Nama Pelanggan:</span><br>{{ $hutang->nama_pelanggan }}</p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><span class="fw-medium">No. HP:</span><br>{{ $hutang->no_hp }}</p>
                </div>
                <div class="col-md-3">
                    <p class="mb-1"><span class="fw-medium">Jumlah Hutang:</span><br>Rp {{ number_format($hutang->jumlah, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($transaksi->piutangs->contains('status', 'lunas'))
        <div class="alert alert-success">
            <h6 class="fw-bold"><i class="fas fa-check-circle me-2"></i>Pembayaran Hutang</h6>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>No. Member</th>
                            <th>Nama Pelanggan</th>
                            <th>No. HP</th>
                            <th class="text-end">Jumlah Dibayar</th>
                            <th>Tanggal Hutang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->piutangs as $p)
                        <tr>
                            <td>{{ $p->no_member ?? '-' }}</td>
                            <td>{{ $p->nama_pelanggan }}</td>
                            <td>{{ $p->no_hp }}</td>
                            <td class="text-end">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                            <td><span class="badge bg-success">Lunas</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($transaksi->detailTransaksi->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 50px">No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->detailTransaksi as $index => $detail)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $detail->barang->kode_barang ?? '-' }}</td>
                        <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $detail->qty }}</td>
                        <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="5" class="text-end">Total</th>
                        <th class="text-end">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
</script>
@endsection