@extends('layouts.app')
@section('title','Masuk')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background:linear-gradient(135deg,#f0f4f8,#e2e8f0)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

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
                    <h1 class="h4 fw-bold">Masuk ke MLEB</h1>
                    <p class="text-muted small">Sistem Pemesanan Tiket Museum Listrik dan Energi Baru</p>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius:16px">
                    <div class="card-body p-4">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                        placeholder="nama@email.com" value="{{ old('email') }}" autofocus required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" id="passwordInput"
                                        class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror"
                                        placeholder="Password Anda" required>
                                    <button type="button" class="input-group-text bg-light border-start-0"
                                        onclick="togglePassword('passwordInput',this)">
                                        <i class="bi bi-eye text-muted"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-4 d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label small" for="remember">Ingat saya</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-mleb w-100 py-2 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>
                        </form>

                        <hr class="my-3">
                        <p class="text-center text-muted small mb-0">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Daftar Gratis</a>
                        </p>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('beranda') }}" class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                    </a>
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
    if (el.type === 'password') {
        el.type = 'text';
        icon.className = 'bi bi-eye-slash text-muted';
    } else {
        el.type = 'password';
        icon.className = 'bi bi-eye text-muted';
    }
}
</script>
@endpush
