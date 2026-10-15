@extends('layout.main')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('main-content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-wallet me-2"></i>Saldo Berjalan</h5>
                <div class="d-flex flex-wrap align-items-stretch gap-2">
                    <div class="rounded-3 px-3 py-2" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); min-width: 230px;">
                        <div class="small text-muted mb-1">
                            <i class="fas fa-arrow-down me-1"></i>Pemasukan dari Owner
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <span class="input-group-text bg-white">Rp</span>
                                <input type="number" id="pemasukanOwnerInput" class="form-control" min="1" step="0.01" placeholder="0">
                            </div>
                            <button type="button" class="btn btn-success btn-sm" id="btnPemasukanOwner">
                                <i class="fas fa-plus me-1"></i>Masuk
                            </button>
                        </div>
                        <div class="small text-muted mt-1">Owner menambah saldo (tercatat sebagai Debet)</div>
                    </div>
                    <div class="rounded-3 px-3 py-2" style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); min-width: 230px;">
                        <div class="small text-muted mb-1">
                            <i class="fas fa-arrow-up me-1"></i>Saldo Keluar ke Owner
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <span class="input-group-text bg-white">Rp</span>
                                <input type="number" id="keluarOwnerInput" class="form-control" min="1" step="0.01" placeholder="0" max="{{ $saldoTersedia > 0 ? $saldoTersedia : 0 }}">
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" id="btnKeluarOwner">
                                <i class="fas fa-minus me-1"></i>Ambil
                            </button>
                        </div>
                        <div class="small text-muted mt-1">
                            Owner mengambil saldo (tercatat sebagai Kredit) &middot;
                            <span class="text-danger fw-semibold">Tersedia: Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="rounded-3 px-3 py-2" style="background: rgba(37, 99, 235, 0.08); border: 1px solid rgba(37, 99, 235, 0.25); min-width: 230px;">
                        <div class="small text-muted mb-1">
                            <i class="fas fa-chart-line me-1"></i>Total Saldo Seluruh Periode
                        </div>
                        <div class="fw-bold" id="totalSaldoBox" style="font-size: 20px; color: var(--primary);">
                            Rp {{ number_format($totalSaldoSeluruhPeriode, 0, ',', '.') }}
                        </div>
                        <div class="small text-muted mt-1">Seluruh debet &minus; kredit</div>
                    </div>
                </div>
                 <div class="d-flex align-items-center gap-2">
                     <select id="bulanKeuangan" class="form-select form-select-sm" style="width: 130px;"></select>
                     <select id="tahunKeuangan" class="form-select form-select-sm" style="width: 100px;"></select>
                     <button type="button" class="btn btn-success btn-sm" onclick="printSection('cetakKeuangan')" title="Cetak">
                         <i class="fas fa-print"></i>
                     </button>
                 </div>
             </div>
             <div class="card-body p-0">
                 <div id="cetakKeuangan" class="table-responsive">
                     <table class="table table-hover mb-0" id="tableSaldo">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th>Tanggal</th>
                                <th>Aktifitas</th>
                                <th class="text-center" style="width: 100px;">Jenis</th>
                                <th class="text-end">Debet</th>
                                <th class="text-end">Kredit</th>
                                <th class="text-end">Saldo</th>
                            </tr>
                        </thead>
                        <tbody id="saldoBody">
                            @php $lastSaldo = 0; @endphp
                            @foreach($saldos as $index => $s)
                            @php $lastSaldo = $s->saldo; @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->created_at)->format('d-m-Y H:i') }}</td>
                                <td>{{ $s->aktifitas }}</td>
                                <td class="text-center">
                                    @if($s->jenis == 'debit')
                                    <span class="badge bg-success">Debet</span>
                                    @else
                                    <span class="badge bg-danger">Kredit</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ $s->jenis == 'debit' ? 'Rp ' . number_format($s->nominal, 0, ',', '.') : '-' }}</td>
                                <td class="text-end">{{ $s->jenis == 'kredit' ? 'Rp ' . number_format($s->nominal, 0, ',', '.') : '-' }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($s->saldo, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-success">
                                <th colspan="6" class="text-end">Saldo Akhir Periode</th>
                                <th class="text-end">Rp {{ number_format($lastSaldo, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <div class="row mb-4">
     <div class="col-md-12">
         <div class="card">
             <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                 <h5 class="mb-0 text-danger fw-bold"><i class="fas fa-hand-holding-usd me-2"></i>Piutang (Hutang Pelanggan)</h5>
                 <div class="d-flex align-items-center gap-2">
                     <span class="badge bg-danger fs-6" id="totalPiutangBadge">Total: Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</span>
                     <select id="bulanPiutang" class="form-select form-select-sm" style="width: 130px;"></select>
                     <select id="tahunPiutang" class="form-select form-select-sm" style="width: 100px;"></select>
                     <button type="button" class="btn btn-success btn-sm" onclick="printSection('cetakPiutang')" title="Cetak">
                         <i class="fas fa-print"></i>
                     </button>
                 </div>
             </div>
             <div class="card-body p-0">
                 <div id="cetakPiutang" class="table-responsive">
                     <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>No. Member</th>
                                <th>Nama Pelanggan</th>
                                <th>No. HP</th>
                                <th>Tanggal Hutang</th>
                                <th>Jumlah Hutang</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="piutangBody">
                            @forelse($piutangs ?? [] as $index => $p)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $p->no_member ?? '-' }}</td>
                                <td class="fw-bold">{{ $p->nama_pelanggan }}</td>
                                <td>{{ $p->no_hp }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                                <td class="text-end fw-bold text-danger">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($p->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                    @else
                                    <span class="badge bg-warning">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($p->status != 'lunas')
                                    <button class="btn btn-sm btn-success" onclick="bayarsPiutang({{ $p->id }})">
                                        <i class="fas fa-check"></i> Bayar
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-check-circle text-success fs-4 mb-2"></i><br>
                                    Tidak ada piutang
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary"><i class="fas fa-chart-bar me-2"></i>Laporan Penjualan</h5>
                <div class="d-flex align-items-center gap-2">
                    <select id="tahunPenjualan" class="form-select form-select-sm" style="width: 100px;"></select>
                    <button type="button" class="btn btn-success btn-sm" onclick="printSection('cetakPenjualan')" title="Cetak">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="cetakPenjualan" class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-medium mb-2"><i class="fas fa-chart-bar me-1"></i>Grafik Penjualan per Bulan</h6>
                        <canvas id="laporanChart" height="200"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-medium mb-2"><i class="fas fa-star me-1"></i>Produk Terlaris</h6>
                        <canvas id="produkTerlarisChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 text-primary"><i class="fas fa-history me-2"></i>Riwayat Transaksi</h5>
                <div class="d-flex align-items-center gap-2">
                    <select id="bulanRiwayat" class="form-select form-select-sm" style="width: 130px;"></select>
                    <select id="tahunRiwayat" class="form-select form-select-sm" style="width: 100px;"></select>
                    <button type="button" class="btn btn-success btn-sm" onclick="printSection('cetakRiwayat')" title="Cetak">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="cetakRiwayat" class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody id="riwayatBody">
                            @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $log->user->name ?? '-' }}</td>
                                <td>{{ $log->aksi }}</td>
                                <td>{{ $log->detail }}</td>
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
    let chart;
    let produkChart;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function E(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (ch) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch];
        });
    }

    function fillYear(tahunId) {
        const curY = new Date().getFullYear();
        const t = document.querySelector(tahunId);
        for (let y = curY; y >= curY - 5; y--) {
            const opt = document.createElement('option');
            opt.value = y;
            opt.textContent = y;
            if (y === curY) opt.selected = true;
            t.appendChild(opt);
        }
    }

    function fillMonthYear(bulanId, tahunId) {
        const curB = new Date().getMonth() + 1;
        const curY = new Date().getFullYear();
        const b = document.querySelector(bulanId);
        const t = document.querySelector(tahunId);
        for (let i = 1; i <= 12; i++) {
            const opt = document.createElement('option');
            opt.value = i;
            opt.textContent = new Date(2000, i - 1).toLocaleString('id-ID', { month: 'long' });
            if (i === curB) opt.selected = true;
            b.appendChild(opt);
        }
        fillYear(tahunId);
    }

    function initChart(data = [0,0,0,0,0,0,0,0,0,0,0,0]) {
        const ctx = document.getElementById('laporanChart').getContext('2d');
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: data,
                    borderColor: '#DC2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); } } }
                }
            }
        });
    }

    function initProdukChart(data) {
        const ctx = document.getElementById('produkTerlarisChart').getContext('2d');
        const labels = data.map(d => d.barang ? d.barang.nama_barang : 'Unknown');
        const qty = data.map(d => d.total_qty);
        
        produkChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: qty,
                    backgroundColor: '#3B82F6',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: { legend: { display: false } }
            }
        });
    }

    function filterKeuangan() {
        const bulan = $('#bulanKeuangan').val();
        const tahun = $('#tahunKeuangan').val();

        $.ajax({
            url: '{{ route("laporan.saldo") }}',
            data: { bulan: bulan, tahun: tahun },
            success: function(saldos) {
                let html = '';
                let no = 1;
                let lastSaldo = 0;
                saldos.forEach(s => {
                    lastSaldo = s.saldo;
                    const date = new Date(s.created_at);
                    const dd = String(date.getDate()).padStart(2, '0');
                    const mm = String(date.getMonth() + 1).padStart(2, '0');
                    const yyyy = date.getFullYear();
                    const jam = String(date.getHours()).padStart(2, '0');
                    const menit = String(date.getMinutes()).padStart(2, '0');
                    const tanggal = `${dd}-${mm}-${yyyy} ${jam}:${menit}`;
                    const debet = s.jenis === 'debit' ? 'Rp ' + parseInt(s.nominal).toLocaleString('id-ID') : '-';
                    const kredit = s.jenis === 'kredit' ? 'Rp ' + parseInt(s.nominal).toLocaleString('id-ID') : '-';
                    const badge = s.jenis === 'debit' ? '<span class="badge bg-success">Debet</span>' : '<span class="badge bg-danger">Kredit</span>';
                    html += `<tr>
                        <td class="text-center">${no++}</td>
                        <td>${tanggal}</td>
                        <td>${E(s.aktifitas)}</td>
                        <td class="text-center">${badge}</td>
                        <td class="text-end">${debet}</td>
                        <td class="text-end">${kredit}</td>
                        <td class="text-end fw-bold">Rp ${parseInt(s.saldo).toLocaleString('id-ID')}</td>
                    </tr>`;
                });
                $('#saldoBody').html(html);
                if (saldos.length > 0) {
                    $('#tableSaldo tfoot').html(`
                        <tr class="table-success">
                            <th colspan="6" class="text-end">Saldo Akhir Periode</th>
                            <th class="text-end">Rp ${parseInt(lastSaldo).toLocaleString('id-ID')}</th>
                        </tr>
                    `);
                }
            }
        });
    }

    function filterPiutang() {
        const bulan = $('#bulanPiutang').val();
        const tahun = $('#tahunPiutang').val();

        $.ajax({
            url: '{{ route("laporan.piutang.data") }}',
            data: { bulan: bulan, tahun: tahun },
            success: function(data) {
                let html = '';
                let total = 0;
                data.forEach((p, i) => {
                    if (p.status === 'belum_lunas') total += parseFloat(p.jumlah);
                    const tanggal = p.tanggal ? new Date(p.tanggal + 'T00:00:00').toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '-';
                    const statusBadge = p.status === 'lunas'
                        ? '<span class="badge bg-success">Lunas</span>'
                        : '<span class="badge bg-warning">Belum Lunas</span>';
                    const aksi = p.status !== 'lunas'
                        ? `<button class="btn btn-sm btn-success" onclick="bayarsPiutang(${p.id})"><i class="fas fa-check"></i> Bayar</button>`
                        : '';
                    html += `<tr>
                        <td class="text-center">${i + 1}</td>
                        <td>${p.no_member ? p.no_member : '-'}</td>
                        <td class="fw-bold">${E(p.nama_pelanggan)}</td>
                        <td>${E(p.no_hp)}</td>
                        <td>${tanggal}</td>
                        <td class="text-end fw-bold text-danger">Rp ${parseInt(p.jumlah).toLocaleString('id-ID')}</td>
                        <td class="text-center">${statusBadge}</td>
                        <td class="text-center">${aksi}</td>
                    </tr>`;
                });
                $('#piutangBody').html(html);
                $('#totalPiutangBadge').text('Total: Rp ' + total.toLocaleString('id-ID'));
            }
        });
    }

    function loadCharts() {
        const tahun = $('#tahunPenjualan').val();

        $.ajax({
            url: '{{ route("laporan.grafik") }}',
            data: { tahun: tahun },
            success: function(data) {
                if (chart) chart.destroy();
                initChart(data);
            }
        });

        $.ajax({
            url: '{{ route("laporan.produk-terlaris") }}',
            data: { tahun: tahun },
            success: function(data) {
                if (produkChart) produkChart.destroy();
                initProdukChart(data);
            }
        });
    }

    function filterRiwayat() {
        const bulan = $('#bulanRiwayat').val();
        const tahun = $('#tahunRiwayat').val();

        $.ajax({
            url: '{{ route("laporan.riwayat") }}',
            data: { bulan: bulan, tahun: tahun },
            success: function(data) {
                let html = '';
                data.forEach(log => {
                    const d = new Date(log.created_at);
                    const tanggal = d.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                    const user = (log.user && log.user.name) ? log.user.name : '-';
                    html += `<tr>
                        <td>${E(tanggal)}</td>
                        <td>${E(user)}</td>
                        <td>${E(log.aksi)}</td>
                        <td>${E(log.detail)}</td>
                    </tr>`;
                });
                $('#riwayatBody').html(html);
            }
        });
    }

    function printSection(id) {
        const live = document.getElementById(id);
        if (!live) return;

        const clone = live.cloneNode(true);
        const liveCanvases = live.querySelectorAll('canvas');
        if (liveCanvases.length) {
            const cloneCanvases = clone.querySelectorAll('canvas');
            liveCanvases.forEach((c, i) => {
                let url = '';
                try { url = c.toDataURL('image/png'); } catch (e) {}
                if (url && cloneCanvases[i]) {
                    const img = document.createElement('img');
                    img.src = url;
                    img.style.maxWidth = '100%';
                    cloneCanvases[i].replaceWith(img);
                }
            });
        }

        const w = window.open('', '_blank', 'width=900,height=700');
        w.document.write('<html><head><title>Cetak Laporan</title><style>body{font-family:Arial,sans-serif;padding:16px;color:#111;font-size:13px;}table{border-collapse:collapse;width:100%;margin-bottom:16px;}th,td{border:1px solid #ddd;padding:6px 8px;}.text-end{text-align:right}.text-center{text-align:center}.fw-bold{font-weight:700}.badge{display:inline-block;padding:4px 8px;border-radius:4px;font-size:11px;color:#fff}.bg-success{background:#10B981}.bg-danger{background:#EF4444}.bg-warning{background:#F59E0B;color:#000}.bg-primary{background:#2563EB}@media print{body{padding:0}}</style></head><body>' + clone.innerHTML + '</body></html>');
        w.document.close();
        w.focus();
        w.print();
    }

    function bayarsPiutang(id) {
        if(confirm('Yakin ingin melunasi piutang ini?')) {
            $.ajax({
                url: '{{ route("laporan.piutang.bayar") }}',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    location.reload();
                }
            });
        }
    }

    $(document).ready(function() {
        fillMonthYear('#bulanKeuangan', '#tahunKeuangan');
        fillMonthYear('#bulanPiutang', '#tahunPiutang');
        fillYear('#tahunPenjualan');
        fillMonthYear('#bulanRiwayat', '#tahunRiwayat');

        $('#bulanKeuangan, #tahunKeuangan').on('change', filterKeuangan);
        $('#bulanPiutang, #tahunPiutang').on('change', filterPiutang);
        $('#tahunPenjualan').on('change', loadCharts);
        $('#bulanRiwayat, #tahunRiwayat').on('change', filterRiwayat);

        filterKeuangan();
        filterPiutang();
        loadCharts();
        filterRiwayat();
    });

    function catatSaldoOwner(tipe, inputId, judul) {
        const nominal = $('#' + inputId).val();
        const maxAttr = $('#keluarOwnerInput').attr('max');
        const maxTersedia = maxAttr ? parseFloat(maxAttr) : 0;

        Swal.fire({
            title: judul,
            input: 'number',
            inputValue: nominal || '',
            inputAttributes: { min: '1', step: '0.01' },
            inputPlaceholder: 'Masukkan nominal (Rp)',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            inputValidator: function(value) {
                const nominal = parseFloat(value);
                if (!nominal || nominal <= 0) {
                    return 'Nominal harus lebih dari 0';
                }
                if (tipe === 'keluar' && nominal > maxTersedia) {
                    return 'Saldo tidak cukup. Saldo tersedia: Rp ' + Math.floor(maxTersedia).toLocaleString('id-ID');
                }
            }
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: '{{ route("laporan.saldo-owner") }}',
                method: 'POST',
                data: { tipe: tipe, nominal: result.value },
                success: function(response) {
                    $('#' + inputId).val('');
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                    setTimeout(() => location.reload(), 1200);
                },
                error: function(xhr) {
                    let msg = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message
                        : 'Gagal mencatat saldo owner';
                    if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.nominal) {
                        msg = xhr.responseJSON.errors.nominal[0];
                    }
                    Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                }
            });
        });
    }

    $('#btnPemasukanOwner').on('click', function() {
        catatSaldoOwner('pemasukan', 'pemasukanOwnerInput', 'Tambah Saldo dari Owner');
    });

    $('#btnKeluarOwner').on('click', function() {
        catatSaldoOwner('keluar', 'keluarOwnerInput', 'Ambil Saldo ke Owner');
    });
</script>
@endsection