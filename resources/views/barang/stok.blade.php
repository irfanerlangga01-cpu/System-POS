@extends('layout.main')

@section('title', 'Stok Barang')
@section('page-title', 'Stok Barang')

@section('main-content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0 text-primary"><i class="fas fa-warehouse me-2"></i>Stok Barang</h5>
                        <small class="text-muted">Kelola dan restok barang di toko</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRestok">
                            <i class="fas fa-plus me-1"></i> Tambah Stok
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="alert alert-info mb-0">
                            <div class="row">
                                <div class="col-md-3">
                                    <i class="fas fa-box me-2"></i>Total Items: <strong>{{ $barangs->count() }}</strong>
                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-cubes me-2"></i>Total Stok: <strong>{{ $barangs->sum('stok') }}</strong>
                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Stok Rendah: <strong class="text-danger">{{ $barangs->where('stok', '<', 10)->count() }}</strong>
                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-money-bill me-2"></i>Nilai Stok: <strong>Rp {{ number_format($barangs->sum(function($b) { return $b->harga * $b->stok; }), 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
<table class="table table-hover table-bordered" id="tableStok">
                         <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px">No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th>Satuan</th>
                                <th class="text-end">Nilai Stok</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $index => $barang)
                            <tr class="{{ $barang->stok < 10 ? 'table-warning' : '' }}">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><span>{{ $barang->kode_barang }}</span></td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td><span class="badge bg-secondary">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                <td class="text-end">Rp {{ number_format($barang->harga_modal ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($barang->stok < 10)
                                    <span class="text-danger">{{ $barang->stok }}</span>
                                    @else
                                    {{ $barang->stok }}
                                    @endif
                                </td>
                                <td>{{ $barang->satuan ?? 'pcs' }}</td>
                                <td class="text-end">Rp {{ number_format($barang->harga * $barang->stok, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($barang->stok < 10)
                                    <span class="stok-rendah"><i class="fas fa-exclamation-triangle me-1"></i>Rendah</span>
                                    @else
                                    <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" onclick="restokBarang({{ $barang->id }})">
                                        <i class="fas fa-plus"></i> Restok
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-primary"><i class="fas fa-history me-2"></i>Riwayat Aktivitas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
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

<div class="modal fade" id="modalRestok" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-plus me-2"></i>Tambah Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRestok">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" id="restokBarangId" class="form-select select2" required>
                            <option value="">Pilih Barang...</option>
                            @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Harga (Opsional)</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" name="harga_modal" class="form-control" placeholder="Harga Modal Baru">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="harga" class="form-control" placeholder="Harga Jual Baru">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRestokItem" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-plus me-2"></i>Restok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formRestokItem">
                <input type="hidden" name="barang_id" id="restokId">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Barang:</strong> <span id="restokNamaBarang"></span><br>
                        <strong>Stok Saat Ini:</strong> <span id="restokStokSekarang"></span><br>
                        <strong>Harga Jual:</strong> <span id="restokHargaJual"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Stok Ditambahkan <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control form-control-lg" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Harga (Opsional)</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" name="harga_modal" class="form-control" placeholder="Harga Modal Baru">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="harga" class="form-control" placeholder="Harga Jual Baru">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let barangData = @json($barangs);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#formRestok').on('submit', function(e) {
        e.preventDefault();
        const barangId = $('#restokBarangId').val();
        const jumlah = parseInt($('#modalRestok input[name="jumlah"]').val()) || 0;
        const hargaModal = $('#modalRestok input[name="harga_modal"]').val();
        const harga = $('#modalRestok input[name="harga"]').val();
        
        if (jumlah < 1) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Jumlah harus lebih dari 0' });
            return;
        }
        
        let data = { barang_id: barangId, jumlah: jumlah };
        if (hargaModal) data.harga_modal = hargaModal;
        if (harga) data.harga = harga;
        
        $.ajax({
            url: '/barang/restock',
            method: 'POST',
            data: data,
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalRestok').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function restokBarang(id) {
        const barang = barangData.find(b => b.id === id);
        if (barang) {
            $('#restokId').val(barang.id);
            $('#restokNamaBarang').text(barang.nama_barang + ' (' + barang.kode_barang + ')');
            $('#restokStokSekarang').text(barang.stok + ' ' + (barang.satuan || 'pcs'));
            $('#restokHargaJual').text('Rp ' + parseInt(barang.harga).toLocaleString('id-ID'));
            $('#modalRestokItem').modal('show');
        }
    }

    $('#formRestokItem').on('submit', function(e) {
        e.preventDefault();
        const barangId = $('#restokId').val();
        const jumlah = parseInt($('#modalRestokItem input[name="jumlah"]').val()) || 0;
        const hargaModal = $('#modalRestokItem input[name="harga_modal"]').val();
        const harga = $('#modalRestokItem input[name="harga"]').val();
        
        if (jumlah < 1) {
            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Jumlah harus lebih dari 0' });
            return;
        }
        
        let data = { barang_id: barangId, jumlah: jumlah };
        if (hargaModal) data.harga_modal = hargaModal;
        if (harga) data.harga = harga;
        
        $.ajax({
            url: '/barang/restock',
            method: 'POST',
            data: data,
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalRestokItem').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });
</script>
@endsection