@extends('layouts.admin')
@section('title', 'Pengaturan Laporan')
@section('content')
<h5 class="fw-bold mb-3">Pengaturan Tanda Tangan Laporan Kunjungan</h5>
<p class="text-muted">Nama, jabatan, dan tanda tangan ini akan dicetak otomatis pada bagian bawah Laporan Kunjungan PDF.</p>
<div class="card shadow-sm"><div class="card-body p-4">
    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Manajer</label>
            <input type="text" name="nama_manajer" class="form-control" value="{{ old('nama_manajer', $pengaturan->nama_manajer) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $pengaturan->jabatan) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanda Tangan (gambar, kosongkan jika tidak diganti)</label>
            <input type="file" name="tanda_tangan" class="form-control" accept="image/*">
            @if($pengaturan->tanda_tangan)
                <img src="{{ asset('images/ttd/'.$pengaturan->tanda_tangan) }}" height="60" class="mt-2">
            @endif
        </div>
        <button class="btn btn-warning fw-semibold">Simpan Pengaturan</button>
    </form>
</div></div>
@endsection
