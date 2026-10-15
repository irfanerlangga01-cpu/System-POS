@extends('layout.main')

@section('title', 'Kategori')
@section('page-title', 'Kategori')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 text-primary"><i class="fas fa-tags me-2"></i>Kategori Barang</h5>
                    <small class="text-muted">Kelola kategori untuk mengorganisir barang</small>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalKategori">
                    <i class="fas fa-plus me-1"></i> Tambah Kategori
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
<table class="table table-hover table-bordered" id="tableKategori">
                         <thead class="table-light">
                             <tr>
                                 <th class="text-center" style="width: 50px">No</th>
                                 <th>Kode Kategori</th>
                                 <th>Nama Kategori</th>
                                 <th>Jumlah Barang</th>
                                 <th>Total Stok</th>
                                 <th>Total Nilai</th>
                                 <th class="text-center">Aksi</th>
                             </tr>
                         </thead>
                        <tbody>
                            @foreach($kategoris as $index => $kategori)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><code>{{ strtoupper($kategori->kode_kategori ?? 'KTG' . str_pad($kategori->id, 3, '0', STR_PAD_LEFT)) }}</code></td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td class="text-center">{{ $kategori->barang->count() }}</td>
                                <td class="text-center">{{ $kategori->barang->sum('stok') }}</td>
                                <td class="text-end">Rp {{ number_format($kategori->barang->sum(function($b) { return $b->harga * $b->stok; }), 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-warning" onclick="editKategori({{ $kategori->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="hapusKategori({{ $kategori->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($kategoris->count() === 0)
                <div class="text-center py-4">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada kategori. Silakan tambah kategori terlebih dahulu.</p>
                </div>
                @endif
            </div>
        </div>

        @if(isset($logs) && $logs->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-primary"><i class="fas fa-history me-2"></i>Riwayat Aktivitas</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
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
        @endif
    </div>
</div>

<div class="modal fade" id="modalKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-plus me-2"></i>Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKategori">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kategori <span class="text-muted">(auto)</span></label>
                        <input type="text" name="kode_kategori" class="form-control" placeholder="Otomatis" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Alat Tulis, Buku, Kertas" required>
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

<div class="modal fade" id="modalEditKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fas fa-edit me-2"></i>Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditKategori">
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kategori</label>
                        <input type="text" name="kode_kategori" id="editKodeKategori" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" id="editNamaKategori" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let kategoriData = @json($kategoris);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#formKategori').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("kategori.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalKategori').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function editKategori(id) {
        const kategori = kategoriData.find(k => k.id === id);
        if (kategori) {
            $('#editId').val(kategori.id);
            $('#editKodeKategori').val(kategori.kode_kategori || '');
            $('#editNamaKategori').val(kategori.nama_kategori);
            $('#modalEditKategori').modal('show');
        }
    }

    $('#formEditKategori').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editId').val();
        $.ajax({
            url: '/kategori/' + id,
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                $('#modalEditKategori').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
            }
        });
    });

    function hapusKategori(id) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: 'Data kategori akan dihapus. Barang dengan kategori ini tidak akan terhapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/kategori/' + id,
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