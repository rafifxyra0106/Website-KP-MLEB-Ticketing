<nav class="navbar navbar-expand-lg navbar-dark sticky-top mleb-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('beranda') }}">
            <i class="bi bi-lightning-charge-fill fs-3 text-warning"></i>
            <span class="fw-bold">MLEB</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('informasi.index') }}">Informasi Museum</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('jadwal.index') }}">Jadwal Kunjungan</a></li>
                @auth
                    @if(!auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('reservasi.create') }}">Reservasi & Tiket</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('reservasi.index') }}">Riwayat Saya</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profil.edit') }}"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</a>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-warning fw-semibold ms-lg-2" type="submit">Keluar</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                    <li class="nav-item"><a class="btn btn-sm btn-warning fw-semibold ms-lg-2" href="{{ route('register') }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
