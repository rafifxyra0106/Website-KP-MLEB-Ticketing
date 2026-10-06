<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Admin') – MLEB Admin</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- DataTables Bootstrap 5 --}}
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    {{-- Admin CSS --}}
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-body">

<div id="wrapper">

    {{-- ═══ SIDEBAR ═══ --}}
    <nav class="admin-sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon-sm"> 
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
                href="{{ route('beranda') }}">
                    <img src="{{ asset('images/logo-mleb.png') }}"
                        alt="MLEB"
                        width="50"
                        height="50"
                        class="rounded">
                </a>
            </i></div>
            <div>
                <div class="fw-bold text-white lh-1" style="font-size:.95rem">MLEB Admin</div>
                <div class="text-white-50" style="font-size:.7rem">Panel Pengelolaan</div>
            </div>
        </div>

        <div class="sidebar-menu">
            <span class="sidebar-label">Menu Utama</span>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>

            <span class="sidebar-label">Tiket &amp; Layanan</span>
            <a href="{{ route('admin.jenis-tiket.index') }}" class="sidebar-link {{ request()->routeIs('admin.jenis-tiket*') ? 'active' : '' }}">
                <i class="bi bi-ticket-perforated"></i><span>Jenis Tiket</span>
            </a>
            <a href="{{ route('admin.bundling-tiket.index') }}" class="sidebar-link {{ request()->routeIs('admin.bundling-tiket*') ? 'active' : '' }}">
                <i class="bi bi-collection"></i><span>Bundling Tiket</span>
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="sidebar-link {{ request()->routeIs('admin.jadwal*') ? 'active' : '' }}">
                <i class="bi bi-calendar-week"></i><span>Jadwal Sesi</span>
            </a>

            <span class="sidebar-label">Transaksi</span>
            <a href="{{ route('admin.reservasi.index') }}" class="sidebar-link {{ request()->routeIs('admin.reservasi*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                <span>Reservasi</span>
                @php $pendingRes = \App\Models\Reservasi::where('status','menunggu_pembayaran')->count() @endphp
                @if($pendingRes > 0)<span class="badge bg-warning text-dark ms-auto">{{ $pendingRes }}</span>@endif
            </a>
            <a href="{{ route('admin.pembayaran.index') }}" class="sidebar-link {{ request()->routeIs('admin.pembayaran*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i>
                <span>Pembayaran</span>
                @php $pendingBay = \App\Models\Pembayaran::where('status','menunggu')->count() @endphp
                @if($pendingBay > 0)<span class="badge bg-danger ms-auto">{{ $pendingBay }}</span>@endif
            </a>
            <a href="{{ route('admin.tiket.index') }}" class="sidebar-link {{ request()->routeIs('admin.tiket*') ? 'active' : '' }}">
                <i class="bi bi-qr-code"></i><span>Tiket Digital</span>
            </a>

            <span class="sidebar-label">Konten</span>
            <a href="{{ route('admin.informasi.index') }}" class="sidebar-link {{ request()->routeIs('admin.informasi*') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i><span>Informasi Museum</span>
            </a>
            <a href="{{ route('admin.kesan.index') }}" class="sidebar-link {{ request()->routeIs('admin.kesan*') ? 'active' : '' }}">
                <i class="bi bi-chat-quote"></i><span>Ulasan Pengunjung</span>
            </a>

            <span class="sidebar-label">Sistem</span>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i><span>Pengguna</span>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="sidebar-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i><span>Laporan</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="avatar-sm flex-shrink-0">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                <div style="min-width:0;overflow:hidden">
                    <div class="text-white fw-semibold text-truncate" style="font-size:.82rem">{{ auth()->user()->name }}</div>
                    <div class="text-white-50" style="font-size:.7rem">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm w-100"
                    style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.8);font-size:.78rem;border:1px solid rgba(255,255,255,.15)">
                    <i class="bi bi-box-arrow-right me-1"></i>Keluar
                </button>
            </form>
        </div>
    </nav>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <div class="admin-content-wrapper" id="contentWrapper">

        {{-- TOPBAR --}}
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light border" id="sidebarToggle" style="display:none">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <h6 class="mb-0 fw-bold text-dark" style="font-size:.95rem">@yield('page-title','Dashboard')</h6>
                    <nav aria-label="breadcrumb" style="font-size:.75rem">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small d-none d-md-block">{{ now()->translatedFormat('l, d F Y') }}</span>
                <a href="{{ route('beranda') }}" class="btn btn-sm btn-outline-primary" target="_blank">
                    <i class="bi bi-eye me-1"></i>Lihat Website
                </a>
            </div>
        </div>

        {{-- PAGE CONTENT --}}
        <div class="admin-page-content">
            @yield('content')
        </div>

    </div>{{-- end admin-content-wrapper --}}
</div>{{-- end #wrapper --}}

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/admin.js') }}"></script>
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
