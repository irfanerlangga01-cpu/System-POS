<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi {{ $transaksi->kode_transaksi }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1E293B;
            background: #F1F5F9;
            padding: 24px;
        }

        .paper {
            max-width: 800px;
            margin: 0 auto;
            background: #FFFFFF;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .toolbar {
            max-width: 800px;
            margin: 0 auto 16px;
            display: flex;
            gap: 10px;
        }

        .toolbar button, .toolbar a {
            font-family: inherit;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-print { background: #2563EB; color: #FFFFFF; }
        .btn-print:hover { background: #1D4ED8; }
        .btn-back { background: #E2E8F0; color: #64748B; }
        .btn-back:hover { background: #CBD5E1; }

        .kop {
            text-align: center;
            border-bottom: 3px double #1E293B;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .kop h1 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .kop h2 {
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            margin-top: 4px;
        }

        .kop p {
            font-size: 12px;
            color: #64748B;
            margin-top: 6px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px 24px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .info table { border-collapse: collapse; }
        .info td { padding: 3px 10px 3px 0; }
        .info .label { color: #64748B; width: 130px; }
        .info .value { font-weight: 600; }

        .status-box {
            text-align: right;
            margin-bottom: 18px;
        }

        .status-box .total {
            font-size: 18px;
            font-weight: 700;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            color: #FFFFFF;
            margin-top: 6px;
        }

        .bg-hutang { background: #F59E0B; }
        .bg-lunas { background: #10B981; }
        .bg-bayar { background: #2563EB; }

        table.daftar {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-bottom: 20px;
        }

        table.daftar th {
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            padding: 10px 8px;
            font-size: 12px;
            text-transform: uppercase;
            color: #475569;
        }

        table.daftar td {
            border: 1px solid #E2E8F0;
            padding: 9px 8px;
        }

        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: 700; }

        .hutang-info {
            border: 1px solid #F59E0B;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .hutang-info h4 {
            font-size: 13px;
            font-weight: 700;
            color: #B45309;
            margin-bottom: 8px;
        }

        .hutang-info .row {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .hutang-info .muted { color: #64748B; font-size: 11px; }

        .ttd {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            font-size: 13px;
        }

        .ttd div { text-align: center; }
        .ttd .nama { margin-top: 56px; font-weight: 600; text-decoration: underline; }

        .catatan {
            margin-top: 24px;
            font-size: 11px;
            color: #94A3B8;
            text-align: center;
        }

        @media print {
            body { background: #FFFFFF; padding: 0; }
            .toolbar { display: none; }
            .paper { box-shadow: none; border-radius: 0; padding: 0; max-width: 100%; }
            table.daftar { page-break-inside: auto; }
            table.daftar tr { page-break-inside: avoid; }
            @page { margin: 12mm; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button type="button" class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Sekarang
        </button>
        <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Detail
        </a>
    </div>

    <div class="paper">
        <div class="kop">
            <h1>ROHMAN</h1>
            <h2>Percetakan &amp; Fotokopi</h2>
            <p>Nota Transaksi</p>
        </div>

        <div class="info">
            <table>
                <tr>
                    <td class="label">Kode Transaksi</td>
                    <td class="value">{{ $transaksi->kode_transaksi }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal</td>
                    <td class="value">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y H:i') }}</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="label">Kasir</td>
                    <td class="value">{{ $transaksi->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Jumlah Item</td>
                    <td class="value">{{ $transaksi->detailTransaksi->sum('qty') }}</td>
                </tr>
            </table>
        </div>

        <div class="status-box">
            <div class="total">Total: Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
            @if($transaksi->piutangs->contains('status', 'belum_lunas'))
                <span class="badge bg-hutang">HUTANG</span>
            @elseif($transaksi->piutangs->isNotEmpty())
                <span class="badge bg-lunas">LUNAS</span>
            @else
                <span class="badge bg-bayar">BAYAR</span>
            @endif
        </div>

        @if($transaksi->piutangs->contains('status', 'belum_lunas'))
            @php $hutang = $transaksi->piutangs->firstWhere('status', 'belum_lunas'); @endphp
            <div class="hutang-info">
                <h4>DATA HUTANG</h4>
            <div class="row">
                <div>
                    <div class="muted">No. Member</div>
                    <div class="fw-bold">{{ $hutang->no_member ?? '-' }}</div>
                </div>
                <div>
                    <div class="muted">Nama Pelanggan</div>
                    <div class="fw-bold">{{ $hutang->nama_pelanggan }}</div>
                </div>
                <div>
                    <div class="muted">No. HP</div>
                    <div class="fw-bold">{{ $hutang->no_hp }}</div>
                </div>
                <div>
                    <div class="muted">Jumlah Hutang</div>
                    <div class="fw-bold">Rp {{ number_format($hutang->jumlah, 0, ',', '.') }}</div>
                </div>
            </div>
            </div>
        @endif

        @if($transaksi->piutangs->contains('status', 'lunas'))
            <table class="daftar">
                <thead>
                    <tr>
                        <th>No. Member</th>
                        <th>Nama Pelanggan</th>
                        <th>No. HP</th>
                        <th class="text-end">Jumlah Dibayar</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->piutangs as $p)
                    <tr>
                        <td>{{ $p->no_member ?? '-' }}</td>
                        <td>{{ $p->nama_pelanggan }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td class="text-end">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if($transaksi->detailTransaksi->isNotEmpty())
            <table class="daftar">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 40px">No</th>
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
                    <tr>
                        <th colspan="5" class="text-end">TOTAL</th>
                        <th class="text-end">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        @endif

        <div class="ttd">
            <div>
                <div>Kasir</div>
                <div class="nama">{{ $transaksi->user->name ?? '-' }}</div>
            </div>
            <div>
                <div>Pelanggan</div>
                <div class="nama">&nbsp;</div>
            </div>
        </div>

        <div class="catatan">
            Terima kasih atas kepercayaan Anda. Barang yang sudah dibeli tidak dapat ditukar.
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
