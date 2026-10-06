<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <i class="bi bi-lightning-charge-fill text-warning fs-3"></i>
        <span class="fw-bold">MLEB Admin</span>
    </div>
    <nav class="nav flex-column sidebar-nav">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a class="nav-link {{ request()->routeIs('admin.informasi.*') ? 'active' : '' }}" href="{{ route('admin.informasi.index') }}"><i class="bi bi-info-circle"></i> Informasi Museum</a>
        <a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}" href="{{ route('admin.jadwal.index') }}"><i class="bi bi-calendar3"></i> Jadwal Operasional</a>
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Kelola Pengguna</a>
        <a class="nav-link {{ request()->routeIs('admin.reservasi.*') ? 'active' : '' }}" href="{{ route('admin.reservasi.index') }}"><i class="bi bi-journal-check"></i> Verifikasi Reservasi</a>
        <a class="nav-link {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}" href="{{ route('admin.pembayaran.index') }}"><i class="bi bi-credit-card"></i> Verifikasi Pembayaran</a>
        <a class="nav-link {{ request()->routeIs('admin.tiket.*') ? 'active' : '' }}" href="{{ route('admin.tiket.index') }}"><i class="bi bi-ticket-perforated"></i> Data Tiket / Check-in</a>
        <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" href="{{ route('admin.laporan.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Kunjungan</a>
        <a class="nav-link {{ request()->routeIs('admin.kesan.*') ? 'active' : '' }}" href="{{ route('admin.kesan.index') }}"><i class="bi bi-chat-heart"></i> Kesan Pengunjung</a>
        <a class="nav-link {{ request()->routeIs('admin.showcase.*') ? 'active' : '' }}" href="{{ route('admin.showcase.index') }}"><i class="bi bi-stars"></i> Showcase Alat</a>
        <a class="nav-link {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}" href="{{ route('admin.pengaturan.edit') }}"><i class="bi bi-gear"></i> Pengaturan Laporan</a>
        <hr class="text-secondary">
        <a class="nav-link" href="{{ route('beranda') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Lihat Situs</a>
    </nav>
</aside>
