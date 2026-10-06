@extends('layouts.admin')
@section('title','Informasi Museum')
@section('page-title','Kelola Informasi Museum')
@section('breadcrumb')<li class="breadcrumb-item active">Informasi Museum</li>@endsection

@section('content')

{{-- ACTION BAR --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <span class="text-muted small">Kelola konten informasi yang tampil di halaman publik museum</span>
            <a href="{{ route('admin.informasi.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-1"></i>Tambah Informasi
            </a>
        </div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-info-circle me-2 text-primary"></i>Daftar Informasi Museum</span>
        <span class="text-muted small">{{ $informasi->total() }} data</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-informasi" class="table mb-0">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th width="80">Gambar</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th width="70" class="text-center">Urutan</th>
                    <th width="80" class="text-center">Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($informasi as $i => $info)
                <tr>
                    <td>{{ $informasi->firstItem() + $i }}</td>
                    <td>
                        @if($info->gambar && file_exists(public_path('images/informasi/'.$info->gambar)))
                        <img src="{{ $info->gambar_url }}" style="width:60px;height:45px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0" alt="{{ $info->judul }}">
                        @else
                        <div style="width:60px;height:45px;background:linear-gradient(135deg,#0f3460,#1a5276);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:1.2rem">⚡</div>
                        @endif
                    </td>
                    <td class="fw-semibold small">{{ $info->judul }}</td>
                    <td class="small text-muted" style="max-width:280px">{{ Str::limit($info->deskripsi, 90) }}</td>
                    <td class="text-center small">{{ $info->urutan }}</td>
                    <td class="text-center">
                        <span class="badge {{ $info->is_active ? 'bg-success' : 'bg-secondary' }}" style="font-size:.72rem">
                            {{ $info->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.informasi.edit', $info->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.informasi.destroy', $info->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-confirm="Hapus informasi '{{ $info->judul }}'?" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-info-circle fs-2 d-block mb-2 opacity-25"></i>
                        Belum ada informasi. <a href="{{ route('admin.informasi.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $informasi->links() }}</div>
</div>

@endsection
