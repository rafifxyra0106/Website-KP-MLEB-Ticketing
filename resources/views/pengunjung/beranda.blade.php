@extends('layouts.app')
@section('title','Beranda')

@section('content')

{{-- HERO --}}
<section class="hero-section">
    <div class="hero-bg-photo">
        <img src="{{ asset('images/showcase/mleb-tampak-depan.jpg') }}" alt="Gedung Museum Listrik dan Energi Baru">
    </div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-badge">
                        <a class="navbar-brand fw-bold d-flex align-items-center gap-2"
                        href="{{ route('beranda') }}">
                            <img src="{{ asset('images/logo-mleb.png') }}"
                                alt="MLEB"
                                width="65"
                                height="65"
                                class="rounded">
                        </a>
                    <span>Museum Interaktif #1 di TMII Jakarta</span>
                </div>
                <h1 class="display-5 fw-bold mb-3">Museum Listrik<br>& Energi Baru</h1>
                <p class="lead opacity-75 mb-4">Jelajahi dunia kelistrikan dan energi terbarukan melalui pengalaman interaktif yang seru dan edukatif untuk semua kalangan.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('reservasi.create') }}" class="btn btn-mleb-yellow btn-lg px-4 fw-bold">
                        <i class="bi bi-ticket-perforated me-2"></i>Pesan Tiket Sekarang
                    </a>
                    <a href="{{ route('jadwal') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-calendar3 me-2"></i>Lihat Jadwal
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                <div class="d-flex flex-wrap gap-2 justify-content-end" style="max-width:340px">
                    @foreach([['⚡','Museum Explore','Rp 20.000'],['🎬','5D Theatre','Rp 30.000'],['🥽','Virtual Reality','Rp 15.000'],['📸','Photo Box','Rp 35.000']] as $w)
                    <div style="background:rgba(255,255,255,.1);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.2);border-radius:14px;padding:.85rem 1.2rem;width:155px">
                        <div style="font-size:1.6rem;margin-bottom:.4rem">{{ $w[0] }}</div>
                        <div style="font-size:.82rem;font-weight:700;color:white">{{ $w[1] }}</div>
                        <div style="font-size:.75rem;color:var(--mleb-yellow)">Mulai {{ $w[2] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS BAR --}}
<div style="background:var(--mleb-secondary);padding:.85rem 0">
    <div class="container">
        <div class="row text-center text-white g-3">
            @foreach([['10.000+','Pengunjung/Tahun'],['6','Wahana Unggulan'],['25+','Tahun Berdiri'],['5.0 ★','Rating Pengunjung']] as $s)
            <div class="col-6 col-md-3">
                <div class="fw-800" style="font-size:1.3rem;font-weight:800">{{ $s[0] }}</div>
                <div style="font-size:.78rem;opacity:.65">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- WAHANA SHOWCASE --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col-lg-6">
                <p class="text-uppercase fw-bold small mb-1" style="color:var(--mleb-yellow);letter-spacing:.08em">Wahana & Atraksi</p>
                <h2 class="fw-bold mb-0" style="color:var(--mleb-primary)">Pengalaman Tak Terlupakan</h2>
            </div>
            <div class="col-lg-6 text-lg-end mt-2 mt-lg-0">
                <p class="text-muted mb-0 small">Tersedia untuk individu, keluarga, maupun rombongan sekolah</p>
            </div>
        </div>

        <div class="row g-3">
            @foreach($wahana as $w)
            <div class="col-sm-6 col-lg-4">
                <div class="wahana-card">
                    @if($w->gambar && file_exists(public_path('images/wahana/'.$w->gambar)))
                        <img src="{{ $w->gambar_url }}" alt="{{ $w->nama }}" style="width:100%;height:160px;object-fit:cover">
                    @else
                        <div class="wahana-icon-box">{{ $w->ikon ?? '⚡' }}</div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary small mb-1">{{ $w->kode }}</span>
                                <h6 class="fw-bold mb-0">{{ $w->nama }}</h6>
                            </div>
                        </div>
                        <p class="small text-muted mb-3">{{ Str::limit($w->deskripsi, 90) }}</p>
                        <div class="d-flex gap-2">
                            <span class="harga-badge"><i class="bi bi-sun me-1"></i>Weekday Rp {{ number_format($w->harga_weekday,0,',','.') }}</span>
                            <span class="harga-badge weekend"><i class="bi bi-star me-1"></i>Weekend Rp {{ number_format($w->harga_weekend,0,',','.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- BUNDLING --}}
<section class="py-5" style="background:white">
    <div class="container">
        <div class="text-center mb-4">
            <p class="text-uppercase fw-bold small mb-1" style="color:var(--mleb-yellow);letter-spacing:.08em">Paket Hemat</p>
            <h2 class="fw-bold" style="color:var(--mleb-primary)">Pilih Bundling Terbaik Anda</h2>
            <p class="text-muted">Nikmati lebih banyak wahana dengan harga yang lebih hemat</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($bundling as $b)
            <div class="col-md-6 col-lg-4">
                <div class="bundling-card">
                    @if($b->badge_label)
                    <span class="bundling-badge">{{ $b->badge_label }}</span>
                    @endif
                    <div style="background:linear-gradient(135deg,var(--mleb-primary),#1a5276);height:100px;display:flex;align-items:center;justify-content:center">
                        <span style="font-size:2.5rem">🎫</span>
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-1">{{ $b->nama }}</h5>
                        <p class="small text-muted mb-3">{{ $b->deskripsi }}</p>
                        <div class="mb-3">
                            <div class="small fw-semibold text-muted mb-2">Termasuk:</div>
                            @foreach($b->jenisTiket as $jt)
                            <span class="badge bg-light text-dark border me-1 mb-1" style="font-weight:500">{{ $jt->ikon }} {{ $jt->nama }}</span>
                            @endforeach
                        </div>
                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            <span class="harga-badge"><i class="bi bi-sun me-1"></i>Weekday Rp {{ number_format($b->harga_weekday,0,',','.') }}</span>
                            <span class="harga-badge weekend"><i class="bi bi-star me-1"></i>Weekend Rp {{ number_format($b->harga_weekend,0,',','.') }}</span>
                        </div>
                        <a href="{{ route('reservasi.create') }}" class="btn btn-mleb w-100">Pesan Bundling Ini</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CARA PESAN --}}
<section class="py-5" style="background:var(--mleb-primary)">
    <div class="container text-center text-white">
        <p class="text-uppercase fw-bold small mb-1" style="color:var(--mleb-yellow);letter-spacing:.08em">Mudah & Cepat</p>
        <h2 class="fw-bold mb-1">Cara Memesan Tiket</h2>
        <p class="opacity-75 mb-5">Hanya 4 langkah mudah untuk menikmati pengalaman museum</p>
        <div class="row g-4">
            @foreach([
                ['1','bi-person-plus','Buat Akun','Daftar gratis dengan email dan nomor WhatsApp Anda'],
                ['2','bi-calendar3','Pilih Jadwal','Tentukan tanggal dan sesi kunjungan yang sesuai'],
                ['3','bi-ticket-perforated','Pilih Tiket','Pilih tiket satuan atau bundling paket hemat'],
                ['4','bi-credit-card','Bayar','Bayar via Virtual Account bank pilihan atau QRIS'],
            ] as $step)
            <div class="col-sm-6 col-lg-3">
                <div class="step-card">
                    <div class="step-number">{{ $step[0] }}</div>
                    <i class="bi {{ $step[1] }} fs-2 mb-2 d-block opacity-75"></i>
                    <h6 class="fw-bold mb-1">{{ $step[2] }}</h6>
                    <p class="small opacity-65 mb-0">{{ $step[3] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            @auth
            <a href="{{ route('reservasi.create') }}" class="btn btn-mleb-yellow btn-lg px-5 fw-bold">
                <i class="bi bi-ticket-perforated me-2"></i>Pesan Tiket Sekarang
            </a>
            @else
            <a href="{{ route('register') }}" class="btn btn-mleb-yellow btn-lg px-5 fw-bold">
                <i class="bi bi-person-plus me-2"></i>Daftar & Pesan Sekarang
            </a>
            @endauth
        </div>
    </div>
</section>

{{-- KESAN PENGUNJUNG --}}
@if($kesan->count())
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <p class="text-uppercase fw-bold small mb-1" style="color:var(--mleb-yellow);letter-spacing:.08em">Ulasan</p>
            <h2 class="fw-bold" style="color:var(--mleb-primary)">Kata Mereka Tentang MLEB</h2>
        </div>
        <div class="row g-3">
            @foreach($kesan as $k)
            <div class="col-md-6 col-lg-4">
                <div class="kesan-card">
                    <div class="rating-stars mb-2">
                        @for($i=1;$i<=5;$i++)
                        <i class="bi {{ $i <= $k->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                    <p class="mb-3 small" style="line-height:1.7;color:#374151">"{{ $k->pesan }}"</p>
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar-sm flex-shrink-0">{{ strtoupper(substr($k->nama_tampil,0,1)) }}</div>
                        <div>
                            <div class="fw-semibold small">{{ $k->nama_tampil }}</div>
                            <div class="text-muted" style="font-size:.72rem">{{ $k->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            @auth
            <a href="{{ route('kesan.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-star me-2"></i>Bagikan Kesan Anda
            </a>
            @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                <i class="bi bi-star me-2"></i>Bagikan Kesan Anda
            </a>
            @endauth
        </div>
    </div>
</section>
@endif

{{-- INFO SINGKAT --}}
@if($informasi->count())
<section class="py-5" style="background:white">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color:var(--mleb-primary)">Tentang Museum</h2>
        </div>
        <div class="row g-4">
            @foreach($informasi as $info)
            <div class="col-md-4">
                <div class="card-mleb card h-100">
                    @if($info->gambar && file_exists(public_path('images/informasi/'.$info->gambar)))
                        <img src="{{ $info->gambar_url }}" class="card-img-top" style="height:180px;object-fit:cover" alt="{{ $info->judul }}">
                    @else
                        <div style="height:120px;background:linear-gradient(135deg,var(--mleb-primary),#1a5276);display:flex;align-items:center;justify-content:center;font-size:2.5rem">⚡</div>
                    @endif
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $info->judul }}</h6>
                        <p class="small text-muted mb-3">{{ Str::limit($info->deskripsi, 100) }}</p>
                        <a href="{{ route('informasi.show',$info->id) }}" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
