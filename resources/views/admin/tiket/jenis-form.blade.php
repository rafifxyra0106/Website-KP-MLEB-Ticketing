{{-- JENIS TIKET FORM --}}
@extends('layouts.admin')
@section('title', $tiket ? 'Edit Tiket' : 'Tambah Tiket')
@section('page-title', $tiket ? 'Edit Jenis Tiket' : 'Tambah Jenis Tiket')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.jenis-tiket.index') }}">Jenis Tiket</a></li>
<li class="breadcrumb-item active">{{ $tiket ? 'Edit' : 'Tambah' }}</li>
@endsection
@section('content')
<div class="admin-card" style="max-width:640px">
    <div class="card-header"><i class="bi bi-ticket me-2 text-primary"></i>{{ $tiket ? 'Edit' : 'Tambah' }} Jenis Tiket</div>
    <div class="card-body">
        <form action="{{ $tiket ? route('admin.jenis-tiket.update',$tiket->id) : route('admin.jenis-tiket.store') }}" method="POST" enctype="multipart/form-data">
            @csrf @if($tiket) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kode <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control text-uppercase" maxlength="10" placeholder="ME, 5D, VR..." value="{{ old('kode',$tiket?->kode) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Tiket <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama',$tiket?->nama) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Ikon</label>
                    <input type="text" name="ikon" class="form-control" placeholder="🎬" value="{{ old('ikon',$tiket?->ikon) }}" maxlength="10">
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi',$tiket?->deskripsi) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga Weekday (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_weekday" class="form-control" min="0" value="{{ old('harga_weekday',$tiket?->harga_weekday ?? 0) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga Weekend (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_weekend" class="form-control" min="0" value="{{ old('harga_weekend',$tiket?->harga_weekend ?? 0) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" min="0" value="{{ old('urutan',$tiket?->urutan ?? 0) }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', $tiket?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Aktif</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Gambar <span class="text-muted fw-normal">(JPG/PNG, maks 2MB)</span></label>
                    @if($tiket && $tiket->gambar && file_exists(public_path('images/wahana/'.$tiket->gambar)))
                    <div class="mb-2"><img src="{{ $tiket->gambar_url }}" id="previewImg" style="max-width:200px;border-radius:8px"></div>
                    @else
                    <img id="previewImg" style="display:none;max-width:200px;border-radius:8px;margin-bottom:.5rem">
                    @endif
                    <input type="file" name="gambar" class="form-control" accept="image/jpg,image/jpeg,image/png" data-preview="previewImg">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>{{ $tiket ? 'Perbarui' : 'Simpan' }}</button>
                <a href="{{ route('admin.jenis-tiket.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
