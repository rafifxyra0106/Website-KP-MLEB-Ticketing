@extends('layouts.admin')
@section('title','Bundling Tiket')
@section('page-title','Kelola Bundling Tiket')
@section('breadcrumb')<li class="breadcrumb-item active">Bundling Tiket</li>@endsection

@section('content')

{{-- ACTION BAR --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <span class="text-muted small">Kelola paket bundling tiket museum</span>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.jenis-tiket.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-ticket me-1"></i>Lihat Jenis Tiket
                </a>
                <a href="{{ route('admin.bundling-tiket.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus me-1"></i>Tambah Bundling
                </a>
            </div>
        </div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-collection me-2 text-primary"></i>Daftar Bundling Tiket</span>
        <span class="text-muted small">{{ count($bundling) }} bundling</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-bundling" class="table mb-0">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Nama Bundling</th>
                    <th>Tiket yang Termasuk</th>
                    <th>Harga Weekday</th>
                    <th>Harga Weekend</th>
                    <th>Badge</th>
                    <th width="80" class="text-center">Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bundling as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="fw-semibold small">{{ $b->nama }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ Str::limit($b->deskripsi, 60) }}</div>
                    </td>
                    <td>
                        @foreach($b->jenisTiket as $jt)
                        <span class="badge bg-light text-dark border me-1 mb-1" style="font-size:.7rem">
                            {{ $jt->ikon }} {{ $jt->nama }}
                        </span>
                        @endforeach
                    </td>
                    <td class="small fw-semibold">Rp {{ number_format($b->harga_weekday,0,',','.') }}</td>
                    <td class="small fw-semibold">Rp {{ number_format($b->harga_weekend,0,',','.') }}</td>
                    <td>
                        @if($b->badge_label)
                        <span class="badge bg-warning text-dark" style="font-size:.72rem">{{ $b->badge_label }}</span>
                        @else
                        <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $b->is_active ? 'bg-success' : 'bg-secondary' }}" style="font-size:.72rem">
                            {{ $b->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.bundling-tiket.edit', $b->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.bundling-tiket.destroy', $b->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-confirm="Hapus bundling '{{ $b->nama }}'?" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-collection fs-2 d-block mb-2 opacity-25"></i>
                        Belum ada bundling tiket. <a href="{{ route('admin.bundling-tiket.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
