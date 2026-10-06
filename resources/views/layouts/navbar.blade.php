<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="/">

            <img src="{{ asset('images/logo-mleb.png') }}"
                alt="MLEB" width="42" height="42" class="me-2">
            <span class="fw-bold">
                MLEB
            </span>

        </a>
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-center">

                @guest

                    <li class="nav-item">
                        <a class="nav-link" href="/">Beranda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('informasi.index') }}">Informasi</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jadwal.index') }}">Jadwal</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>

                    <li class="nav-item ms-2">
                        <a href="{{ route('register') }}" class="btn btn-warning">
                            Daftar
                        </a>
                    </li>

                @else

                    <li class="nav-item">
                        <a class="nav-link" href="/">Beranda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('informasi.index') }}">Informasi</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jadwal.index') }}">Jadwal</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reservasi.index') }}">Reservasi</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('riwayat') }}">Riwayat</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tiket.index') }}">Tiket Saya</a>
                    </li>

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->name }}

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow">

                            <li class="px-3 py-2">

                                <strong>{{ Auth::user()->name }}</strong>

                                <br>

                                <small class="text-muted">
                                    {{ Auth::user()->email }}
                                </small>

                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a href="{{ route('profil.index') }}"
                                   class="dropdown-item">

                                    <i class="fas fa-user me-2"></i>
                                    Profil Saya

                                </a>
                            </li>

                            <li>
                                <a href="{{ route('tiket.index') }}"
                                   class="dropdown-item">

                                    <i class="fas fa-ticket-alt me-2"></i>
                                    Tiket Saya

                                </a>
                            </li>

                            <li>
                                <a href="{{ route('riwayat') }}"
                                   class="dropdown-item">

                                    <i class="fas fa-clock-rotate-left me-2"></i>
                                    Riwayat Reservasi

                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>

                                <form action="{{ route('logout') }}" method="POST">

                                    @csrf

                                    <button type="submit"
                                            class="dropdown-item text-danger">

                                        <i class="fas fa-right-from-bracket me-2"></i>
                                        Logout

                                    </button>

                                </form>

                            </li>

                        </ul>

                    </li>

                @endguest

            </ul>

        </div>

    </div>
</nav>