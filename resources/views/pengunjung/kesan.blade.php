{{-- KESAN FORM: resources/views/pengunjung/kesan.blade.php --}}
@extends('layouts.app')
@section('title','Beri Kesan & Ulasan')
@section('content')
<div class="page-header"><div class="container"><h1><i class="bi bi-star me-2"></i>Beri Kesan & Ulasan</h1><p class="mb-0">Bagikan pengalaman kunjungan Anda kepada kami</p></div></div>
<section class="py-4"><div class="container" style="max-width:640px">
<div class="card-mleb card">
    <div class="card-header"><i class="bi bi-chat-quote me-2 text-primary"></i>Form Ulasan</div>
    <div class="card-body">
        <form action="{{ route('kesan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kunjungan <span class="text-danger">*</span></label>
                <select name="reservasi_id" class="form-select" required>
                    <option value="">-- Pilih kunjungan yang sudah selesai --</option>
                    @foreach($reservasiSelesai as $r)
                    <option value="{{ $r->id }}" {{ old('reservasi_id')==$r->id?'selected':'' }}>{{ $r->kode_reservasi }} – {{ $r->tanggal_kunjungan->format('d/m/Y') }}</option>
                    @endforeach
                </select>
                <div class="form-text">Ulasan hanya dapat diberikan untuk kunjungan yang telah selesai.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Tampil <span class="text-danger">*</span></label>
                <input type="text" name="nama_tampil" class="form-control" placeholder="Nama yang akan ditampilkan" value="{{ old('nama_tampil', auth()->user()->name) }}" required maxlength="100">
                <div class="form-text">Nama ini yang akan tampil di halaman ulasan publik</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Rating <span class="text-danger">*</span></label>
                <div class="d-flex gap-2">
                    @for($i=1;$i<=5;$i++)
                    <label style="cursor:pointer;font-size:1.8rem">
                        <input type="radio" name="rating" value="{{ $i }}" class="d-none rating-radio" {{ old('rating',5)==$i?'checked':'' }}>
                        <span class="star-label" data-val="{{ $i }}" style="color:{{ old('rating',5)>=$i?'#f5a623':'#dee2e6' }}">★</span>
                    </label>
                    @endfor
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Kesan & Pesan <span class="text-danger">*</span></label>
                <textarea name="pesan" class="form-control" rows="5" minlength="10" maxlength="1000" required placeholder="Ceritakan pengalaman kunjungan Anda di museum...">{{ old('pesan') }}</textarea>
                <div class="form-text">Minimal 10, maksimal 1000 karakter</div>
            </div>
            <button type="submit" class="btn btn-mleb-yellow fw-bold w-100 py-2">
                <i class="bi bi-send me-2"></i>Kirim Ulasan
            </button>
        </form>
    </div>
</div>
</div></section>
@endsection
@push('scripts')
<script>
document.querySelectorAll('.star-label').forEach(function(star) {
    star.addEventListener('click', function() {
        var val = parseInt(this.dataset.val);
        document.querySelectorAll('input[name="rating"]').forEach(function(r, i) {
            r.checked = (i+1) === val;
        });
        document.querySelectorAll('.star-label').forEach(function(s, i) {
            s.style.color = (i+1) <= val ? '#f5a623' : '#dee2e6';
        });
    });
});
</script>
@endpush
