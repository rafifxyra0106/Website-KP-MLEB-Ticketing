@extends('layouts.admin')
@section('title', $bundling ? 'Edit Bundling' : 'Tambah Bundling')
@section('page-title', $bundling ? 'Edit Bundling Tiket' : 'Tambah Bundling Tiket')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.bundling-tiket.index') }}">Bundling</a></li>
<li class="breadcrumb-item active">{{ $bundling ? 'Edit' : 'Tambah' }}</li>
@endsection
@section('content')
<div class="admin-card" style="max-width:640px">
    <div class="card-header"><i class="bi bi-collection me-2 text-primary"></i>{{ $bundling ? 'Edit' : 'Tambah' }} Bundling Tiket</div>
    <div class="card-body">
        <form action="{{ $bundling ? route('admin.bundling-tiket.update',$bundling->id) : route('admin.bundling-tiket.store') }}" method="POST">
            @csrf @if($bundling) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label">Nama Bundling <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama',$bundling?->nama) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi',$bundling?->deskripsi) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tiket yang Termasuk <span class="text-danger">*</span></label>
                <div class="row g-2">
                    @foreach($semuaTiket as $t)
                    <div class="col-sm-6">
                        <div class="form-check border rounded p-3">
                            <input class="form-check-input" type="checkbox" name="tiket_ids[]" value="{{ $t->id }}" id="tiket_{{ $t->id }}"
                                {{ (is_array(old('tiket_ids')) && in_array($t->id, old('tiket_ids'))) || ($bundling && $bundling->jenisTiket->pluck('id')->contains($t->id)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tiket_{{ $t->id }}">{{ $t->ikon }} <strong>{{ $t->nama }}</strong></label>
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('tiket_ids')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Harga Weekday (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_weekday" class="form-control" min="0" value="{{ old('harga_weekday',$bundling?->harga_weekday ?? 0) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga Weekend (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_weekend" class="form-control" min="0" value="{{ old('harga_weekend',$bundling?->harga_weekend ?? 0) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Label Badge</label>
                    <input type="text" name="badge_label" class="form-control" placeholder="Hemat 15%, Terlaris..." value="{{ old('badge_label',$bundling?->badge_label) }}" maxlength="50">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control" min="0" value="{{ old('urutan',$bundling?->urutan ?? 0) }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" {{ old('is_active', $bundling?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>{{ $bundling ? 'Perbarui' : 'Simpan' }}</button>
                <a href="{{ route('admin.bundling-tiket.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
