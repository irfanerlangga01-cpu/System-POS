@extends('layout.main')

@section('title', 'Data Barang')
@section('page-title', 'Data Barang')

@section('main-content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-box me-2"></i>Data Barang</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <input type="text" id="searchBarang" class="form-control" placeholder="Cari..." style="width: 220px;">
                    <select id="filterKategori" class="form-select" style="width: 180px;">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <select id="filterStatus" class="form-select" style="width: 160px;">
                        <option value="">Semua Status</option>
                        <option value="rendah">Stok Rendah</option>
                        <option value="tersedia">Tersedia</option>
                    </select>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBarang">
                        <i class="fas fa-plus me-1"></i> Tambah Barang
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableBarang">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th class="text-end">Harga Modal</th>
                                <th class="text-end">Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-end">Keuntungan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach($barangs as $index => $barang)
                            <tr data-kategori="{{ $barang->kategori_id }}" data-stok="{{ $barang->stok }}">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><span>{{ $barang->kode_barang }}</span></td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td><span class="badge bg-biru">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                <td class="text-end">Rp {{ number_format($barang->harga_modal ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($barang->stok < 10)
                                    <span class="text-danger">{{ $barang->stok }}</span>
                                    @else
                                    {{ $barang->stok }}
                                    @endif
                                </td>
                                <td class="text-end">Rp {{ number_format(($barang->harga - ($barang->harga_modal ?? 0)) * $barang->stok, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($barang->stok < 10)
                                    <span class="stok-rendah"><i class="fas fa-exclamation-triangle me-1"></i>Stok Rendah</span>
                                    @else
                                    <span class="badge bg-hijau">Tersedia</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-warning" onclick="editBarang({{ $barang->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="hapusBarang({{ $barang->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @php
                                $totalModal = $barangs->sum(function($b) { return ($b->harga_modal ?? 0) * $b->stok; });
                                $totalJual = $barangs->sum(function($b) { return $b->harga * $b->stok; });
                                $keuntungan = $totalJual - $totalModal;
                                $totalStok = $barangs->sum('stok');
                            @endphp
                            <tr class="table-light">
                                <th colspan="4" class="text-end">Total</th>
                                <th class="text-end">Rp {{ number_format($totalModal, 0, ',', '.') }}</th>
                                <th class="text-end">Rp {{ number_format($totalJual, 0, ',', '.') }}</th>
                                <th class="text-center">{{ $totalStok }}</th>
                                <th class="text-end text-success">Rp {{ number_format($keuntungan, 0, ',', '.') }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-2">
                    <small class="text-muted">Menampilkan {{ $barangs->count() }} dari {{ $barangs->count() }} barang | Stok Rendah: {{ $barangs->where('stok', '<', 10)->count() }}</small>
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

<div class="modal fade" id="modalBarang" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-plus me-2"></i>Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formBarang">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Barang <span class="text-muted">(auto)</span></label>
                                <input type="text" name="kode_barang" class="form-control" placeholder="Otomatis" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Pensil 2B" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Satuan</label>
                                <select name="satuan" class="form-select">
                                    <option value="pcs">Pcs (PCS)</option>
                                    <option value="pcs">pcs</option>
                                    <option value="box">Box</option>
                                    <option value="rim">Rim</option>
                                    <option value="pack">Pack</option>
                                    <option value="lusin">Lusin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga Modal (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga_modal" class="form-control" placeholder="Harga Modal" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga" class="form-control" placeholder="0" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control" placeholder="0" min="0" value="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBarang" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-edit me-2"></i>Edit Harga Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditBarang">
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" id="editNamaBarang" class="form-control" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga Modal (Rp)</label>
                                <input type="number" name="harga_modal" id="editHargaModal" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga Jual (Rp)</label>
                                <input type="number" name="harga" id="editHarga" class="form-control" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Harga</button>
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

    $('#searchBarang').on('keyup', function() {
        filterTable();
    });

    $('#filterKategori, #filterStatus').on('change', function() {
        filterTable();
    });

    function filterTable() {
        const search = $('#searchBarang').val().toLowerCase();
        const kategori = $('#filterKategori').val();
        const status = $('#filterStatus').val();
        
        $('#tableBody tr').each(function() {
            const row = $(this);
            const kode = row.find('td:nth-child(2)').text().toLowerCase();
            const nama = row.find('td:nth-child(3)').text().toLowerCase();
            const rowKategori = row.data('kategori');
            const stok = parseInt(row.data('stok'));
            
            let show = true;
            
            if (search && !kode.includes(search) && !nama.includes(search)) {
                show = false;
            }
            
            if (kategori && rowKategori != kategori) {
                show = false;
            }
            
            if (status === 'rendah' && stok >= 10) {
                show = false;
            }
            
            if (status === 'tersedia' && stok < 10) {
                show = false;
            }
            
            row.toggle(show);
        });
    }

    $('#formBarang').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("barang.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalBarang').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    $('#modalBarang').on('show.bs.modal', function() {
        $('#formBarang')[0].reset();
        const lastId = barangData.length > 0 ? Math.max(...barangData.map(b => b.id)) : 0;
        const newCode = 'BRG' + String(lastId + 1).padStart(5, '0');
        $('input[name="kode_barang"]').val(newCode);
    });

    function editBarang(id) {
        const barang = barangData.find(b => b.id === id);
        if (barang) {
            $('#editId').val(barang.id);
            $('#editNamaBarang').val(barang.nama_barang);
            $('#editHargaModal').val(barang.harga_modal || 0);
            $('#editHarga').val(barang.harga);
            $('#modalEditBarang').modal('show');
        }
    }

    $('#formEditBarang').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editId').val();
        $.ajax({
            url: '/barang/' + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalEditBarang').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function hapusBarang(id) {
        Swal.fire({
            title: 'Hapus Barang?',
            text: 'Data barang akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/barang/' + id,
                    method: 'DELETE',
                    success: function(response) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
                    }
                });
            }
        });
    }
</script>
@endsection