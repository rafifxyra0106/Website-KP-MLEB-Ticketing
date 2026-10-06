@extends('layouts.admin')
@section('title','Jenis Tiket')
@section('page-title','Kelola Jenis Tiket')
@section('breadcrumb')<li class="breadcrumb-item active">Jenis Tiket</li>@endsection

@section('content')

{{-- ACTION BAR --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <span class="text-muted small">Kelola tiket satuan yang tersedia di museum</span>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.bundling-tiket.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-collection me-1"></i>Lihat Bundling
                </a>
                <a href="{{ route('admin.jenis-tiket.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus me-1"></i>Tambah Tiket
                </a>
            </div>
        </div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-ticket me-2 text-primary"></i>Daftar Jenis Tiket</span>
        <span class="text-muted small">{{ count($tiket) }} tiket</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-jenis-tiket" class="table mb-0">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th width="80">Kode</th>
                    <th>Nama Tiket</th>
                    <th>Deskripsi</th>
                    <th>Harga Weekday</th>
                    <th>Harga Weekend</th>
                    <th width="70" class="text-center">Urutan</th>
                    <th width="80" class="text-center">Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tiket as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><span class="badge bg-secondary">{{ $t->kode }}</span></td>
                    <td>
                        <div class="fw-semibold small">{{ $t->ikon }} {{ $t->nama }}</div>
                        @if($t->gambar)
                        <div class="text-muted" style="font-size:.72rem">Ada gambar</div>
                        @endif
                    </td>
                    <td class="small text-muted" style="max-width:220px">{{ Str::limit($t->deskripsi, 70) }}</td>
                    <td class="small fw-semibold">Rp {{ number_format($t->harga_weekday,0,',','.') }}</td>
                    <td class="small fw-semibold">Rp {{ number_format($t->harga_weekend,0,',','.') }}</td>
                    <td class="text-center small">{{ $t->urutan }}</td>
                    <td class="text-center">
                        <span class="badge {{ $t->is_active ? 'bg-success' : 'bg-secondary' }}" style="font-size:.72rem">
                            {{ $t->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.jenis-tiket.edit', $t->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.jenis-tiket.destroy', $t->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-confirm="Hapus tiket '{{ $t->nama }}'?" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-ticket fs-2 d-block mb-2 opacity-25"></i>
                        Belum ada jenis tiket. <a href="{{ route('admin.jenis-tiket.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
