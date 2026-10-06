<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MLEB') – Museum Listrik dan Energi Baru</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background:var(--mleb-primary);">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
        href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo-mleb.png') }}"
                alt="MLEB"
                width="65"
                height="65"
                class="rounded">
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('informasi*') ? 'active' : '' }}" href="{{ route('informasi') }}">Informasi</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('jadwal') ? 'active' : '' }}" href="{{ route('jadwal') }}">Jadwal</a></li>
                @auth
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('reservasi*') ? 'active' : '' }}" href="{{ route('reservasi.create') }}">Pesan Tiket</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('riwayat') ? 'active' : '' }}" href="{{ route('riwayat') }}">Riwayat</a></li>
                @endauth
            </ul>
            <ul class="navbar-nav align-items-lg-center gap-2">
                @auth
                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm fw-semibold" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Admin Panel
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" data-bs-toggle="dropdown">
                            <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('profil') }}"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('riwayat') }}"><i class="bi bi-clock-history me-2"></i>Riwayat Pesanan</a></li>
                            <li><a class="dropdown-item" href="{{ route('kesan.create') }}"><i class="bi bi-star me-2"></i>Beri Kesan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm fw-semibold px-3" href="{{ route('register') }}">Daftar Gratis</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- FLASH MESSAGES (toast) -->

<!-- CONTENT -->
<main>@yield('content')</main>

<!-- FOOTER -->
<footer class="footer-main mt-auto">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="brand-icon">
                            <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
                            href="{{ route('beranda') }}">
                                <img src="{{ asset('images/logo-mleb.png') }}"
                                    alt="MLEB"
                                    width="50"
                                    height="50"
                                    class="rounded">
                            </a>
                    </div>
                </div>
                <p class="text-white-50 small">Museum Listrik dan Energi Baru – pusat edukasi dan rekreasi teknologi kelistrikan dan energi terbarukan di Indonesia.</p>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-semibold mb-3">Navigasi</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li><a href="{{ route('informasi') }}">Informasi</a></li>
                    <li><a href="{{ route('jadwal') }}">Jadwal</a></li>
                    <li><a href="{{ route('reservasi.create') }}">Pesan Tiket</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="text-white fw-semibold mb-3">Jam Operasional</h6>
                <ul class="list-unstyled text-white-50 small">
                    <li class="mb-1"><i class="bi bi-calendar3 me-2"></i>Selasa – Minggu</li>
                    <li class="mb-1"><i class="bi bi-clock me-2"></i>09.00 – 17.00 WIB</li>
                    <li><i class="bi bi-x-circle me-2"></i>Tutup setiap Senin</li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white fw-semibold mb-3">Kontak</h6>
                <ul class="list-unstyled text-white-50 small">
                    <li class="mb-1"><i class="bi bi-geo-alt me-2"></i>TMII, Jakarta Timur</li>
                    <li class="mb-1"><i class="bi bi-telephone me-2"></i>(021) 8779-3000</li>
                    <li><i class="bi bi-envelope me-2"></i>info@mleb.tmii.co.id</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <p class="text-center text-white-50 small mb-0">© {{ date('Y') }} Museum Listrik dan Energi Baru – TMII Jakarta. Hak cipta dilindungi.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Custom JS -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
@if(session('success'))
    mlebToast('success', @json(session('success')));
@endif
@if(session('sukses'))
    mlebToast('success', @json(session('sukses')));
@endif
@if(session('error'))
    mlebToast('error', @json(session('error')));
@endif
@if(session('gagal'))
    mlebToast('error', @json(session('gagal')));
@endif
@if($errors->any())
    mlebToast('error', @json($errors->first()), 5000);
@endif
</script>
@stack('scripts')
</body>
</html>
