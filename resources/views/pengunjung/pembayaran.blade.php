@extends('layouts.app')
@section('title','Pembayaran')

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-credit-card me-2"></i>Selesaikan Pembayaran</h1>
        <p class="mb-0">Pilih metode pembayaran dan selesaikan transaksi Anda</p>
    </div>
</div>

<section class="py-4">
<div class="container">
<div class="row g-4">

    {{-- KIRI: PILIH METODE / INSTRUKSI --}}
    <div class="col-lg-8">

        @if(!$reservasi->pembayaran)
        {{-- FORM PILIH METODE --}}
        <div class="card-mleb card">
            <div class="card-header">
                <i class="bi bi-wallet2 me-2 text-primary"></i>
                <span>Pilih Metode Pembayaran</span>
            </div>
            <div class="card-body">
                <form action="{{ route('pembayaran.pilih', $reservasi->id) }}" method="POST">
                    @csrf
                    @error('metode')<div class="alert alert-danger py-2 small">{{ $message }}</div>@enderror

                    {{-- VIRTUAL ACCOUNT --}}
                    <h6 class="fw-bold mb-3"><i class="bi bi-bank me-2"></i>Virtual Account Bank</h6>
                    <div class="row g-2 mb-4">
                        @foreach([
                            ['bca_va',    'BCA',     '#005387', '🔵'],
                            ['mandiri_va','Mandiri',  '#003d79', '🟡'],
                            ['bni_va',    'BNI',     '#f47920', '🟠'],
                            ['bri_va',    'BRI',     '#003ca6', '🔷'],
                        ] as $m)
                        <div class="col-sm-6">
                            <label class="d-block" style="cursor:pointer">
                                <input type="radio" name="metode" value="{{ $m[0] }}" class="d-none metode-radio">
                                <div class="payment-box metode-box">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:44px;height:28px;background:{{ $m[2] }};border-radius:5px;display:flex;align-items:center;justify-content:center">
                                            <span style="color:white;font-size:.65rem;font-weight:800">{{ $m[1] }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold small">Virtual Account {{ $m[1] }}</div>
                                            <div class="text-muted" style="font-size:.72rem">Transfer antar bank 24 jam</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    {{-- QRIS --}}
                    <h6 class="fw-bold mb-3"><i class="bi bi-qr-code-scan me-2"></i>QRIS</h6>
                    <div class="row g-2 mb-4">
                        <div class="col-sm-6">
                            <label class="d-block" style="cursor:pointer">
                                <input type="radio" name="metode" value="qris" class="d-none metode-radio">
                                <div class="payment-box metode-box">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:44px;height:44px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.5rem">
                                            📱
                                        </div>
                                        <div>
                                            <div class="fw-semibold small">QRIS</div>
                                            <div class="text-muted" style="font-size:.72rem">Scan & bayar dari semua e-wallet / m-banking</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="alert alert-warning py-2 small">
                        <i class="bi bi-clock me-1"></i>
                        Pembayaran berlaku selama <strong>24 jam</strong> setelah metode dipilih.
                    </div>

                    <button type="submit" class="btn btn-mleb btn-lg w-100 fw-semibold" id="btnPilihMetode" disabled>
                        <i class="bi bi-arrow-right-circle me-2"></i>Lanjutkan Pembayaran
                    </button>
                </form>
            </div>
        </div>

        @else
        {{-- INSTRUKSI PEMBAYARAN --}}
        @php $p = $reservasi->pembayaran; @endphp

        @if($p->status === 'terkonfirmasi')
        <div class="alert alert-success d-flex gap-3 align-items-center">
            <i class="bi bi-check-circle-fill fs-3 flex-shrink-0"></i>
            <div>
                <div class="fw-bold">Pembayaran Berhasil Dikonfirmasi!</div>
                <div class="small">Tiket digital Anda sudah siap. Silakan cek di halaman detail pesanan.</div>
                <a href="{{ route('reservasi.show', $reservasi->id) }}" class="btn btn-success btn-sm mt-2">Lihat Tiket Digital</a>
            </div>
        </div>
        @else

        <div class="card-mleb card">
            <div class="card-header">
                <div>
                    <span class="fw-bold">{{ $p->label_metode }}</span>
                    @if($p->expired_at)
                    <div class="small text-muted mt-1">
                        <i class="bi bi-clock me-1"></i>Berlaku hingga: <strong>{{ $p->expired_at->format('d/m/Y H:i') }} WIB</strong>
                    </div>
                    @endif
                </div>
                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
            </div>
            <div class="card-body">
                @if($p->metode === 'qris')
                {{-- QRIS --}}
                <div class="text-center py-3">
                    <p class="text-muted small mb-3">Scan QR code berikut menggunakan aplikasi e-wallet atau mobile banking Anda:</p>
                    <div style="width:220px;height:220px;border:3px solid #e2e8f0;border-radius:16px;margin:0 auto;display:flex;align-items:center;justify-content:center;background:#f8f9fa;font-size:4rem">
                        📱
                    </div>
                    <div class="mt-3 p-2 bg-light rounded small text-muted">
                        Kode: <code>{{ $p->kode_qris }}</code>
                    </div>
                    <div class="mt-3">
                        <div class="fw-bold fs-5" style="color:var(--mleb-primary)">Rp {{ number_format($p->total,0,',','.') }}</div>
                        <div class="text-muted small">Nominal yang harus dibayarkan</div>
                    </div>
                </div>
                <hr>
                <div class="small">
                    <p class="fw-semibold mb-2">Cara Pembayaran QRIS:</p>
                    <ol class="ps-3 text-muted" style="line-height:2">
                        <li>Buka aplikasi dompet digital atau mobile banking Anda</li>
                        <li>Pilih menu <strong>Scan QR / QRIS</strong></li>
                        <li>Scan kode QR di atas</li>
                        <li>Pastikan nominal: <strong>Rp {{ number_format($p->total,0,',','.') }}</strong></li>
                        <li>Konfirmasi pembayaran</li>
                        <li>Klik tombol <strong>"Saya Sudah Bayar"</strong> di bawah</li>
                    </ol>
                </div>

                @else
                {{-- VIRTUAL ACCOUNT --}}
                <div class="text-center mb-4">
                    <p class="text-muted small mb-2">Transfer ke nomor Virtual Account berikut:</p>
                    <div class="va-number-box">
                        <div class="text-muted small mb-1">{{ $p->nama_bank }} Virtual Account</div>
                        <div class="va-number" id="nomorVA">{{ $p->nomor_va }}</div>
                        <button class="btn btn-sm btn-outline-primary mt-2" data-copy="{{ $p->nomor_va }}">
                            <i class="bi bi-copy me-1"></i>Salin Nomor
                        </button>
                    </div>
                    <div class="mt-3">
                        <div class="fw-bold fs-5" style="color:var(--mleb-primary)">Rp {{ number_format($p->total,0,',','.') }}</div>
                        <div class="text-muted small">Nominal yang harus ditransfer <strong>(sesuai nominal, tidak kurang/lebih)</strong></div>
                    </div>
                </div>
                <hr>
                <div class="small">
                    <p class="fw-semibold mb-2">Cara Pembayaran Virtual Account {{ $p->nama_bank }}:</p>
                    @if($p->metode === 'bca_va')
                    <ol class="ps-3 text-muted" style="line-height:2">
                        <li>Login ke BCA Mobile / KlikBCA</li>
                        <li>Pilih <strong>Transfer → BCA Virtual Account</strong></li>
                        <li>Masukkan nomor VA: <strong>{{ $p->nomor_va }}</strong></li>
                        <li>Masukkan nominal: <strong>Rp {{ number_format($p->total,0,',','.') }}</strong></li>
                        <li>Konfirmasi & selesaikan pembayaran</li>
                    </ol>
                    @elseif($p->metode === 'mandiri_va')
                    <ol class="ps-3 text-muted" style="line-height:2">
                        <li>Login ke Livin' by Mandiri</li>
                        <li>Pilih <strong>Pembayaran → Multi Payment</strong></li>
                        <li>Cari <strong>MLEB Museum</strong>, masukkan kode: <strong>{{ $p->nomor_va }}</strong></li>
                        <li>Konfirmasi nominal dan lanjutkan</li>
                    </ol>
                    @elseif($p->metode === 'bni_va')
                    <ol class="ps-3 text-muted" style="line-height:2">
                        <li>Login ke BNI Mobile Banking</li>
                        <li>Pilih <strong>Transfer → Virtual Account Billing</strong></li>
                        <li>Masukkan nomor VA: <strong>{{ $p->nomor_va }}</strong></li>
                        <li>Konfirmasi & selesaikan pembayaran</li>
                    </ol>
                    @elseif($p->metode === 'bri_va')
                    <ol class="ps-3 text-muted" style="line-height:2">
                        <li>Login ke BRImo</li>
                        <li>Pilih <strong>Pembayaran → BRIVA</strong></li>
                        <li>Masukkan nomor VA: <strong>{{ $p->nomor_va }}</strong></li>
                        <li>Konfirmasi & selesaikan pembayaran</li>
                    </ol>
                    @endif
                </div>
                @endif

                {{-- TOMBOL KONFIRMASI MANUAL --}}
                <div class="mt-4 pt-3 border-top">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Setelah melakukan pembayaran, klik tombol di bawah untuk konfirmasi.
                        Tim kami akan memverifikasi pembayaran Anda.
                    </p>
                    <form action="{{ route('pembayaran.konfirmasi', $p->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100 fw-semibold"
                            data-confirm="Konfirmasi bahwa Anda sudah melakukan pembayaran sebesar Rp {{ number_format($p->total,0,',','.') }}?">
                            <i class="bi bi-check-circle me-2"></i>Saya Sudah Melakukan Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>

    {{-- KANAN: RINGKASAN PESANAN --}}
    <div class="col-lg-4">
        <div class="card-mleb card sticky-lg-top sticky-side-card">
            <div class="card-header"><i class="bi bi-receipt me-2 text-primary"></i>Ringkasan Pesanan</div>
            <div class="card-body p-0">
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Kode Pesanan</span>
                        <span class="fw-bold small" style="color:var(--mleb-primary)">{{ $reservasi->kode_reservasi }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Tanggal Kunjungan</span>
                        <span class="fw-semibold small">{{ $reservasi->tanggal_kunjungan->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Sesi</span>
                        <span class="fw-semibold small">{{ $reservasi->jadwal->nama_sesi }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Jam</span>
                        <span class="fw-semibold small">{{ $reservasi->jadwal->jam }}</span>
                    </div>
                </div>

                <div class="p-3 border-bottom">
                    @foreach($reservasi->detail as $d)
                    <div class="d-flex justify-content-between py-1">
                        <span class="small">{{ $d->nama_item }} <span class="text-muted">×{{ $d->jumlah }}</span></span>
                        <span class="small fw-semibold">Rp {{ number_format($d->subtotal,0,',','.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="p-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold fs-5" style="color:var(--mleb-primary)">
                            Rp {{ number_format($reservasi->total_harga,0,',','.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('reservasi.show', $reservasi->id) }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Detail Pesanan
            </a>
        </div>
    </div>

</div>
</div>
</section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.metode-radio').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.metode-box').forEach(b => b.classList.remove('selected'));
        this.closest('label').querySelector('.metode-box').classList.add('selected');
        document.getElementById('btnPilihMetode').disabled = false;
    });
});
</script>
@endpush
