<div class="sidebar">

<div class="sidebar-header">

                <h4>
                    <img src="{{ asset('images/logo-mleb.png') }}"
                            alt="MLEB" width="42" height="42" class="me-2">
                    MLEB
                </h4>

            </div>

            <ul>

            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-gauge-high"></i> Dashboard</a> </li>

            <li><a href="{{ route('admin.informasi.index') }}" class="{{ request()->routeIs('admin.informasi.*') ? 'active' : '' }}">
            <i class="fas fa-circle-info"></i> Informasi</a></li>

            <li><a href="{{ route('admin.jadwal.index') }}" class="{{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-days"></i> Jadwal</a></li>

            <li><a href="{{ route('admin.reservasi.index') }}" class="{{ request()->routeIs('admin.reservasi.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i> Reservasi</a></li>

            <li><a href="{{ route('admin.pembayaran.index') }}" class="{{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i> Pembayaran </a></li>

            <li><a href="{{ route('admin.tiket.index') }}" class="{{ request()->routeIs('admin.tiket.*') ? 'active' : '' }}">
            <i class="fas fa-ticket"></i> Tiket</a></li>

            <li><a href="{{ route('admin.pengguna.index') }}" class="{{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Pengguna</a></li>

            <li> <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Laporan</a></li>

            <li> <form action="{{ route('logout') }}" method="POST">

            @csrf

            <button
            type="submit"
            class="logout-btn">

            Logout

                </button>
            </form>
        </li>
    </ul>
</div>