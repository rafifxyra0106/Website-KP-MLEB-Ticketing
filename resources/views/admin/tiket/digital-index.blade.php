@extends('layouts.admin')
@section('title','Tiket Digital')
@section('page-title','Data Tiket Digital')
@section('breadcrumb')<li class="breadcrumb-item active">Tiket Digital</li>@endsection

@section('content')

{{-- FILTER --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="status" class="form-select form-select-sm" style="max-width:180px">
                <option value="">Semua Status</option>
                <option value="aktif"     {{ request('status')=='aktif'     ? 'selected':'' }}>Aktif</option>
                <option value="digunakan" {{ request('status')=='digunakan' ? 'selected':'' }}>Digunakan</option>
                <option value="expired"   {{ request('status')=='expired'   ? 'selected':'' }}>Expired</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search me-1"></i>Filter</button>
            @if(request('status'))
            <a href="{{ route('admin.tiket.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-qr-code me-2 text-primary"></i>Daftar Tiket Digital</span>
        <span class="text-muted small">{{ $tiket->total() }} data</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-tiket" class="table mb-0">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Kode Tiket</th>
                    <th>Pengunjung</th>
                    <th>Kode Reservasi</th>
                    <th>Tgl Kunjungan</th>
                    <th class="text-center">Status</th>
                    <th>Digunakan Pada</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tiket as $i => $t)
                <tr>
                    <td>{{ $tiket->firstItem() + $i }}</td>
                    <td style="font-family:monospace;font-size:.78rem;color:var(--mleb-primary);font-weight:700">
                        {{ $t->kode_tiket }}
                    </td>
                    <td>
                        <div class="fw-semibold small">{{ $t->reservasi->user->name ?? '-' }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $t->reservasi->user->email ?? '' }}</div>
                    </td>
                    <td class="small fw-semibold" style="color:var(--mleb-primary)">
                        {{ $t->reservasi->kode_reservasi ?? '-' }}
                    </td>
                    <td class="small">
                        {{ $t->reservasi->tanggal_kunjungan?->format('d/m/Y') ?? '-' }}
                        <div class="text-muted" style="font-size:.72rem">{{ $t->reservasi->jadwal->nama_sesi ?? '' }}</div>
                    </td>
                    <td class="text-center">
                        @php
                            $cls = match($t->status) {
                                'aktif'     => 'bg-success',
                                'digunakan' => 'bg-secondary',
                                'expired'   => 'bg-warning text-dark',
                                default     => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $cls }}" style="font-size:.72rem">{{ ucfirst($t->status) }}</span>
                    </td>
                    <td class="small text-muted">{{ $t->digunakan_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.tiket.show', $t->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-qr-code fs-2 d-block mb-2 opacity-25"></i>
                        Belum ada tiket digital
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $tiket->links() }}</div>
</div>

@endsection
