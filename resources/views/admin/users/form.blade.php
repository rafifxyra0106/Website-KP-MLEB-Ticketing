@extends('layouts.admin')
@section('title', $user ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('page-title', $user ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
<li class="breadcrumb-item active">{{ $user ? 'Edit' : 'Tambah' }}</li>
@endsection
@section('content')
<div class="admin-card" style="max-width:600px">
    <div class="card-header"><i class="bi bi-person me-2 text-primary"></i>{{ $user ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</div>
    <div class="card-body">
        <form action="{{ $user ? route('admin.users.update',$user->id) : route('admin.users.store') }}" method="POST">
            @csrf @if($user) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name',$user?->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email',$user?->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone',$user?->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <option value="pengunjung" {{ old('role',$user?->role)=='pengunjung'?'selected':'' }}>Pengunjung</option>
                        <option value="admin" {{ old('role',$user?->role)=='admin'?'selected':'' }}>Admin</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password {{ $user ? '(kosongkan jika tidak diubah)' : '' }} @if(!$user)<span class="text-danger">*</span>@endif</label>
                    <input type="password" name="password" class="form-control" {{ !$user ? 'required' : '' }} minlength="8" placeholder="Min. 8 karakter">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>{{ $user ? 'Perbarui' : 'Simpan' }}</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
