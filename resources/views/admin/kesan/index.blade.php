@extends('layouts.admin')
@section('title','Ulasan Pengunjung')
@section('page-title','Kelola Ulasan Pengunjung')
@section('breadcrumb')<li class="breadcrumb-item active">Ulasan Pengunjung</li>@endsection

@section('content')

{{-- FILTER --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="rating" class="form-select form-select-sm" style="max-width:160px">
                <option value="">Semua Rating</option>
                @for($r=5;$r>=1;$r--)
                <option value="{{ $r }}" {{ request('rating')==$r ? 'selected':'' }}>
                    {{ str_repeat('★',$r) }} ({{ $r }} Bintang)
                </option>
                @endfor
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search me-1"></i>Filter</button>
            @if(request('rating'))
            <a href="{{ route('admin.kesan.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-chat-quote me-2 text-primary"></i>Daftar Ulasan Pengunjung</span>
        <span class="text-muted small">{{ $kesan->total() }} ulasan</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-kesan" class="table mb-0">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Nama Tampil</th>
                    <th>Rating</th>
                    <th>Pesan / Ulasan</th>
                    <th>Pengguna</th>
                    <th>Tanggal</th>
                    <th class="text-center" width="80">Tampil</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kesan as $i => $k)
                <tr>
                    <td>{{ $kesan->firstItem() + $i }}</td>
                    <td class="fw-semibold small">{{ $k->nama_tampil }}</td>
                    <td>
                        <span style="color:#f5a623;font-size:.9rem">
                            @for($s=1;$s<=5;$s++)
                            <i class="bi bi-{{ $s <= $k->rating ? 'star-fill' : 'star' }}"></i>
                            @endfor
                        </span>
                        <span class="text-muted small ms-1">({{ $k->rating }})</span>
                    </td>
                    <td class="small" style="max-width:260px">{{ Str::limit($k->pesan, 80) }}</td>
                    <td class="small text-muted">{{ $k->user->name }}</td>
                    <td class="small text-muted">{{ $k->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <form action="{{ route('admin.kesan.toggle', $k->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $k->is_visible ? 'btn-success' : 'btn-outline-secondary' }}" title="{{ $k->is_visible ? 'Sembunyikan' : 'Tampilkan' }}">
                                <i class="bi bi-{{ $k->is_visible ? 'eye' : 'eye-slash' }}"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.kesan.destroy', $k->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" data-confirm="Hapus ulasan dari '{{ $k->nama_tampil }}'?" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-chat-quote fs-2 d-block mb-2 opacity-25"></i>
                        Belum ada ulasan dari pengunjung
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $kesan->links() }}</div>
</div>

@endsection
