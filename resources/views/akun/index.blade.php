@extends('layout.main')

@section('title', 'Kelola Akun')
@section('page-title', 'Kelola Akun')

@section('main-content')
<div class="row">
    @if(Auth::user()->role === 'admin')
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-primary"><i class="fas fa-user-plus me-2"></i>Tambah Akun Karyawan</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('akun.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Tambah
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <div class="@if(Auth::user()->role === 'admin') col-md-8 @else col-md-12 @endif">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 text-primary"><i class="fas fa-users me-2"></i>Daftar Akun</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-merah">Admin</span>
                                    @else
                                        <span class="badge bg-biru">Karyawan</span>
                                    @endif
                                </td>
                                <td>
                                    @if(Auth::user()->role === 'admin' || Auth::user()->id === $user->id)
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif
                                    @if(Auth::user()->role === 'admin' && $user->id !== Auth::id())
                                        <form method="POST" action="{{ route('akun.destroy', $user->id) }}" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(Auth::user()->role === 'admin')
        <div class="card">
            <div class="card-header">
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
                                <td>{{ $log->user->name }}</td>
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

@foreach($users as $user)
<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Akun - {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('akun.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru (kosongkan jika tidak change)</label>
                        <input type="password" name="password" class="form-control" placeholder="Password baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection