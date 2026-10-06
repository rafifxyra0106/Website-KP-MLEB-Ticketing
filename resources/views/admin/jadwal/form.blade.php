@extends('layouts.admin')
@section('title', $jadwal ? 'Edit Sesi' : 'Tambah Sesi')
@section('page-title', $jadwal ? 'Edit Sesi Jadwal' : 'Tambah Sesi Jadwal')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal</a></li>
<li class="breadcrumb-item active">{{ $jadwal ? 'Edit' : 'Tambah' }}</li>
@endsection
@section('content')
<div class="admin-card" style="max-width:600px">
    <div class="card-header"><i class="bi bi-calendar-week me-2 text-primary"></i>{{ $jadwal ? 'Edit Sesi' : 'Tambah Sesi Baru' }}</div>
    <div class="card-body">
        <form action="{{ $jadwal ? route('admin.jadwal.update',$jadwal->id) : route('admin.jadwal.store') }}" method="POST">
            @csrf @if($jadwal) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label">Nama Sesi <span class="text-danger">*</span></label>
                <input type="text" name="nama_sesi" class="form-control" placeholder="Contoh: Sesi Pagi" value="{{ old('nama_sesi',$jadwal?->nama_sesi) }}" required>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                    <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', $jadwal ? \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') : '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                    <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', $jadwal ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '') }}" required>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Kuota Weekday <span class="text-danger">*</span></label>
                    <input type="number" name="kuota_weekday" class="form-control" min="1" value="{{ old('kuota_weekday',$jadwal?->kuota_weekday ?? 50) }}" required>
                    <div class="form-text">Senin – Jumat</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kuota Weekend <span class="text-danger">*</span></label>
                    <input type="number" name="kuota_weekend" class="form-control" min="1" value="{{ old('kuota_weekend',$jadwal?->kuota_weekend ?? 80) }}" required>
                    <div class="form-text">Sabtu – Minggu</div>
                </div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" min="0" value="{{ old('urutan',$jadwal?->urutan ?? 0) }}">
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $jadwal?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Sesi Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>{{ $jadwal ? 'Perbarui' : 'Simpan' }}</button>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
