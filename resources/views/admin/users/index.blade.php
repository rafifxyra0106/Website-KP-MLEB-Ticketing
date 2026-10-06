@extends('layouts.admin')
@section('title','Data Pengguna')
@section('page-title','Kelola Data Pengguna')
@section('breadcrumb')<li class="breadcrumb-item active">Pengguna</li>@endsection

@section('content')

{{-- FILTER --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center justify-content-between">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <input type="text" name="search" class="form-control form-control-sm"
                    style="max-width:220px" placeholder="Cari nama / email..."
                    value="{{ request('search') }}">
                <select name="role" class="form-select form-select-sm" style="max-width:150px">
                    <option value="">Semua Role</option>
                    <option value="pengunjung" {{ request('role')=='pengunjung' ? 'selected':'' }}>Pengunjung</option>
                    <option value="admin"      {{ request('role')=='admin'      ? 'selected':'' }}>Admin</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search me-1"></i>Cari</button>
                @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                @endif
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus me-1"></i>Tambah Pengguna
            </a>
        </form>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-people me-2 text-primary"></i>Daftar Pengguna</span>
        <span class="text-muted small">{{ $users->total() }} pengguna</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-users" class="table mb-0">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th width="90">Role</th>
                    <th class="text-center" width="90">Reservasi</th>
                    <th width="110">Bergabung</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $u)
                <tr>
                    <td>{{ $users->firstItem() + $i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm flex-shrink-0">{{ strtoupper(substr($u->name,0,1)) }}</div>
                            <div class="fw-semibold small">{{ $u->name }}</div>
                        </div>
                    </td>
                    <td class="small text-muted">{{ $u->email }}</td>
                    <td class="small text-muted">{{ $u->phone ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $u->role === 'admin' ? 'bg-primary' : 'bg-light text-dark border' }}" style="font-size:.72rem">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td class="text-center small fw-semibold">{{ $u->reservasi_count }}</td>
                    <td class="small text-muted">{{ $u->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($u->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    data-confirm="Hapus pengguna '{{ $u->name }}'? Semua data reservasinya juga akan terhapus."
                                    title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-people fs-2 d-block mb-2 opacity-25"></i>
                        Belum ada pengguna terdaftar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $users->links() }}</div>
</div>

@endsection
