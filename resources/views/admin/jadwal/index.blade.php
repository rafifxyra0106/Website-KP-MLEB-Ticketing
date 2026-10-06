@extends('layouts.admin')
@section('title','Jadwal Sesi')
@section('page-title','Kelola Jadwal Sesi Kunjungan')
@section('breadcrumb')<li class="breadcrumb-item active">Jadwal Sesi</li>@endsection

@section('content')

{{-- ACTION BAR --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
            <span class="text-muted small">Kelola sesi kunjungan harian museum (kuota weekday & weekend terpisah)</span>
            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-1"></i>Tambah Sesi
            </a>
        </div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-calendar-week me-2 text-primary"></i>Daftar Sesi Kunjungan</span>
        <span class="text-muted small">{{ count($jadwal) }} sesi</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-jadwal" class="table mb-0">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Nama Sesi</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th class="text-center">Kuota Weekday</th>
                    <th class="text-center">Kuota Weekend</th>
                    <th class="text-center" width="70">Urutan</th>
                    <th class="text-center" width="80">Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $i => $j)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $j->nama_sesi }}</td>
                    <td class="small">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} WIB</td>
                    <td class="small">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }} WIB</td>
                    <td class="text-center small fw-semibold">{{ $j->kuota_weekday }} <span class="text-muted fw-normal">orang</span></td>
                    <td class="text-center small fw-semibold">{{ $j->kuota_weekend }} <span class="text-muted fw-normal">orang</span></td>
                    <td class="text-center small">{{ $j->urutan }}</td>
                    <td class="text-center">
                        <span class="badge {{ $j->is_active ? 'bg-success' : 'bg-secondary' }}" style="font-size:.72rem">
                            {{ $j->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-confirm="Hapus sesi '{{ $j->nama_sesi }}'?" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-week fs-2 d-block mb-2 opacity-25"></i>
                        Belum ada sesi jadwal. <a href="{{ route('admin.jadwal.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
