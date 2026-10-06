@extends('layouts.admin')
@section('title', isset($info) ? 'Edit Informasi' : 'Tambah Informasi')
@section('page-title', isset($info) ? 'Edit Informasi' : 'Tambah Informasi')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.informasi.index') }}">Informasi</a></li>
<li class="breadcrumb-item active">{{ isset($info) ? 'Edit' : 'Tambah' }}</li>
@endsection
@section('content')
<div class="admin-card" style="max-width:700px">
    <div class="card-header"><i class="bi bi-info-circle me-2 text-primary"></i>{{ isset($info) ? 'Edit Informasi' : 'Tambah Informasi Baru' }}</div>
    <div class="card-body">
        <form action="{{ isset($info) ? route('admin.informasi.update',$info->id) : route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf @if(isset($info)) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label">Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul',$info?->judul) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                <textarea name="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi',$info?->deskripsi) }}</textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" value="{{ old('urutan',$info?->urutan ?? 0) }}" min="0">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $info?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Tampilkan (Aktif)</label>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Gambar <span class="text-muted fw-normal">(JPG/PNG, maks 2MB)</span></label>
                @if(isset($info) && $info->gambar && file_exists(public_path('images/informasi/'.$info->gambar)))
                <div class="mb-2"><img src="{{ $info->gambar_url }}" id="previewImg" style="max-width:200px;border-radius:8px;border:2px solid #e2e8f0"></div>
                @else
                <img id="previewImg" style="display:none;max-width:200px;border-radius:8px;margin-bottom:.5rem">
                @endif
                <input type="file" name="gambar" class="form-control" accept="image/jpg,image/jpeg,image/png" data-preview="previewImg">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>{{ isset($info) ? 'Perbarui' : 'Simpan' }}</button>
                <a href="{{ route('admin.informasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
