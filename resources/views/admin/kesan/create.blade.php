@extends('layouts.admin')
@section('title', 'Tambah Kesan Pengunjung')
@section('content')
<div class="card shadow-sm"><div class="card-body p-4">
    <form action="{{ route('admin.kesan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3"><label class="form-label">Nama Pengunjung</label><input type="text" name="nama_pengunjung" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Asal Rombongan (opsional)</label><input type="text" name="asal_rombongan" class="form-control" placeholder="Contoh: SDN 02 Cikarang"></div>
        <div class="mb-3"><label class="form-label">Pesan / Kesan</label><textarea name="pesan" rows="4" class="form-control" maxlength="500" required></textarea></div>
        <div class="mb-3"><label class="form-label">Rating (opsional)</label>
            <select name="rating" class="form-select"><option value="">-</option>@for($i=1;$i<=5;$i++)<option value="{{ $i }}">{{ $i }}</option>@endfor</select>
        </div>
        <div class="mb-3"><label class="form-label">Foto (opsional)</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
        <button class="btn btn-warning fw-semibold">Simpan & Tampilkan</button>
    </form>
</div></div>
@endsection
