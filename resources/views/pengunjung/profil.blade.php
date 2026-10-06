@extends('layouts.app')
@section('title','Profil Saya')
@section('content')
<div class="page-header"><div class="container"><h1><i class="bi bi-person-circle me-2"></i>Profil Saya</h1><p class="mb-0">Kelola informasi akun dan keamanan Anda</p></div></div>
<section class="py-4"><div class="container" style="max-width:700px">

<div class="row g-3 mb-4">
    <div class="col-sm-4"><div class="card-mleb card text-center p-3"><div style="width:64px;height:64px;background:var(--mleb-primary);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.8rem;color:white;margin:0 auto .75rem">{{ strtoupper(substr($user->name,0,1)) }}</div><div class="fw-bold">{{ $user->name }}</div><div class="text-muted small">{{ ucfirst($user->role) }}</div></div></div>
    <div class="col-sm-4"><div class="card-mleb card text-center p-3"><div class="fw-bold fs-3" style="color:var(--mleb-primary)">{{ $totalReservasi }}</div><div class="text-muted small">Total Pesanan</div></div></div>
    <div class="col-sm-4"><div class="card-mleb card text-center p-3"><div class="fw-bold fs-3" style="color:#16a34a">{{ $totalSelesai }}</div><div class="text-muted small">Kunjungan Selesai</div></div></div>
</div>

<div class="card-mleb card mb-3">
    <div class="card-header"><i class="bi bi-person me-2 text-primary"></i>Informasi Akun</div>
    <div class="card-body">
        <form action="{{ route('profil.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required></div>
                <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required></div>
                <div class="col-md-6"><label class="form-label">No. Telepon</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}"></div>
                <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2">{{ old('address',$user->address) }}</textarea></div>
            </div>
            <button type="submit" class="btn btn-mleb mt-3"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
        </form>
    </div>
</div>

<div class="card-mleb card">
    <div class="card-header"><i class="bi bi-shield-lock me-2 text-primary"></i>Ganti Password</div>
    <div class="card-body">
        <form action="{{ route('profil.password') }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Password Saat Ini</label>
                    <div class="input-group">
                        <input type="password" name="current_password" id="curPw" class="form-control" placeholder="Masukkan password saat ini" required>
                        <button type="button" class="btn btn-toggle-pw border" onclick="togglePassword('curPw',this)"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="password" id="newPw" class="form-control" placeholder="Min. 8 karakter" required>
                        <button type="button" class="btn btn-toggle-pw border" onclick="togglePassword('newPw',this)"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="newPwConfirm" class="form-control" placeholder="Ulangi password baru" required>
                        <button type="button" class="btn btn-toggle-pw border" onclick="togglePassword('newPwConfirm',this)"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-danger mt-3"><i class="bi bi-lock me-2"></i>Ganti Password</button>
        </form>
    </div>
</div>

</div></section>
@endsection

@push('scripts')
<script>
function togglePassword(id, btn) {
    var el = document.getElementById(id);
    var icon = btn.querySelector('i');
    el.type = el.type === 'password' ? 'text' : 'password';
    icon.className = el.type === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
}
</script>
@endpush
