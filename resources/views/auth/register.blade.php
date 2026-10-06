@extends('layouts.app')
@section('title','Daftar Akun')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background:linear-gradient(135deg,#f0f4f8,#e2e8f0)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="text-center mb-4">
                    <div class="brand-icon mx-auto mb-3" style="width:60px;height:60px;font-size:1.6rem">
                            <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
                            href="{{ route('beranda') }}">
                                <img src="{{ asset('images/logo-mleb.png') }}"
                                    alt="MLEB"
                                    width="65"
                                    height="65"
                                    class="rounded">
                            </a>
                    </div>
                    <h1 class="h4 fw-bold">Buat Akun Baru</h1>
                    <p class="text-muted small">Daftar untuk memesan tiket kunjungan museum</p>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius:16px">
                    <div class="card-body p-4">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                        placeholder="Nama lengkap Anda" value="{{ old('name') }}" required>
                                </div>
                                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                        placeholder="nama@email.com" value="{{ old('email') }}" required>
                                </div>
                                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Telepon / WhatsApp <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone text-muted"></i></span>
                                    <input type="text" name="phone" class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror"
                                        placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                                </div>
                                @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" id="pw1"
                                        class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror"
                                        placeholder="Minimal 8 karakter" required>
                                    <button type="button" class="input-group-text bg-light border-start-0" onclick="togglePassword('pw1',this)">
                                        <i class="bi bi-eye text-muted"></i>
                                    </button>
                                </div>
                                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                    <input type="password" name="password_confirmation" id="pw2"
                                        class="form-control border-start-0 border-end-0 ps-0"
                                        placeholder="Ulangi password" required>
                                    <button type="button" class="input-group-text bg-light border-start-0" onclick="togglePassword('pw2',this)">
                                        <i class="bi bi-eye text-muted"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="alert alert-info py-2 small mb-3">
                                <i class="bi bi-shield-check me-1"></i>
                                Data Anda aman dan hanya digunakan untuk keperluan pemesanan tiket.
                            </div>

                            <button type="submit" class="btn btn-mleb w-100 py-2 fw-semibold">
                                <i class="bi bi-person-plus me-2"></i>Buat Akun Sekarang
                            </button>
                        </form>

                        <hr class="my-3">
                        <p class="text-center text-muted small mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Masuk</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(id, btn) {
    var el = document.getElementById(id);
    var icon = btn.querySelector('i');
    el.type = el.type === 'password' ? 'text' : 'password';
    icon.className = el.type === 'text' ? 'bi bi-eye-slash text-muted' : 'bi bi-eye text-muted';
}
</script>
@endpush
