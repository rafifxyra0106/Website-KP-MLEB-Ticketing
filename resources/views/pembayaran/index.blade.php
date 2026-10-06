@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')

<div class="container py-5">

    <div class="pay-page">

        @if(!$reservasi)

            <div class="panel">
                <div class="panel-body text-center py-5">
                    <i class="fas fa-circle-check" style="font-size:2.5rem;color:var(--gray-light);"></i>
                    <h5 class="mt-3 mb-2">Tidak ada pembayaran yang menunggu</h5>
                    <p class="text-muted mb-3">Anda tidak memiliki reservasi yang perlu dibayar saat ini.</p>
                    <a href="{{ route('reservasi.create') }}" class="btn btn-primary">
                        Buat Reservasi Baru
                    </a>
                </div>
            </div>

        @else

            <div class="pay-summary">
                <div class="pay-code">{{ $reservasi->kode_reservasi }}</div>
                <div class="pay-amount">
                    <small>Total Bayar</small>
                    Rp {{ number_format($reservasi->total_harga,0,',','.') }}
                </div>
            </div>

            <div class="panel">

                <div class="panel-header">
                    <h3><i class="fas fa-wallet"></i> Pilih Metode Pembayaran</h3>
                </div>

                <div class="panel-body">

                    <form action="{{ route('pembayaran.proses') }}" method="POST" id="payForm">

                        @csrf

                        <input type="hidden" name="reservasi_kunjungan_id" value="{{ $reservasi->id }}">

                        <div class="pay-methods">

                            <div class="pay-method-option">
                                <input type="radio" name="metode_pembayaran" id="metode_qris" value="QRIS" checked>
                                <label for="metode_qris">
                                    <span class="pm-icon"><i class="fas fa-qrcode"></i></span>
                                    <span class="pm-name">QRIS</span>
                                    <span class="pm-desc">Scan & bayar dari e-wallet/m-banking apa saja</span>
                                </label>
                            </div>

                            <div class="pay-method-option">
                                <input type="radio" name="metode_pembayaran" id="metode_va" value="Virtual Account">
                                <label for="metode_va">
                                    <span class="pm-icon"><i class="fas fa-building-columns"></i></span>
                                    <span class="pm-name">Virtual Account</span>
                                    <span class="pm-desc">Transfer bank melalui ATM/m-banking</span>
                                </label>
                            </div>

                        </div>

                        <!-- QRIS Panel -->
                        <div class="pay-detail-panel active" id="panel_qris">

                            <div class="qr-box">
                                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="200" height="200" fill="#ffffff"/>
                                    <rect x="10" y="10" width="50" height="50" fill="#1f2937"/>
                                    <rect x="20" y="20" width="30" height="30" fill="#ffffff"/>
                                    <rect x="28" y="28" width="14" height="14" fill="#1f2937"/>
                                    <rect x="140" y="10" width="50" height="50" fill="#1f2937"/>
                                    <rect x="150" y="20" width="30" height="30" fill="#ffffff"/>
                                    <rect x="158" y="28" width="14" height="14" fill="#1f2937"/>
                                    <rect x="10" y="140" width="50" height="50" fill="#1f2937"/>
                                    <rect x="20" y="150" width="30" height="30" fill="#ffffff"/>
                                    <rect x="28" y="158" width="14" height="14" fill="#1f2937"/>
                                    <g fill="#1f2937">
                                        <rect x="70" y="10" width="8" height="8"/><rect x="86" y="10" width="8" height="8"/><rect x="110" y="10" width="8" height="8"/>
                                        <rect x="70" y="26" width="8" height="8"/><rect x="94" y="26" width="8" height="8"/><rect x="118" y="26" width="8" height="8"/>
                                        <rect x="78" y="42" width="8" height="8"/><rect x="102" y="42" width="8" height="8"/><rect x="126" y="42" width="8" height="8"/>
                                        <rect x="10" y="70" width="8" height="8"/><rect x="26" y="70" width="8" height="8"/><rect x="42" y="78" width="8" height="8"/>
                                        <rect x="70" y="70" width="8" height="8"/><rect x="86" y="78" width="8" height="8"/><rect x="102" y="70" width="8" height="8"/><rect x="118" y="86" width="8" height="8"/><rect x="134" y="70" width="8" height="8"/>
                                        <rect x="150" y="78" width="8" height="8"/><rect x="166" y="70" width="8" height="8"/><rect x="182" y="78" width="8" height="8"/>
                                        <rect x="10" y="94" width="8" height="8"/><rect x="34" y="102" width="8" height="8"/><rect x="58" y="94" width="8" height="8"/>
                                        <rect x="78" y="102" width="8" height="8"/><rect x="94" y="110" width="8" height="8"/><rect x="110" y="102" width="8" height="8"/><rect x="126" y="118" width="8" height="8"/>
                                        <rect x="150" y="102" width="8" height="8"/><rect x="174" y="110" width="8" height="8"/>
                                        <rect x="18" y="118" width="8" height="8"/><rect x="42" y="126" width="8" height="8"/>
                                        <rect x="70" y="134" width="8" height="8"/><rect x="86" y="126" width="8" height="8"/><rect x="110" y="134" width="8" height="8"/>
                                        <rect x="142" y="126" width="8" height="8"/><rect x="158" y="134" width="8" height="8"/><rect x="182" y="126" width="8" height="8"/>
                                        <rect x="70" y="150" width="8" height="8"/><rect x="94" y="158" width="8" height="8"/><rect x="118" y="150" width="8" height="8"/>
                                        <rect x="142" y="158" width="8" height="8"/><rect x="166" y="150" width="8" height="8"/><rect x="182" y="166" width="8" height="8"/>
                                        <rect x="70" y="174" width="8" height="8"/><rect x="94" y="182" width="8" height="8"/><rect x="118" y="174" width="8" height="8"/>
                                        <rect x="142" y="182" width="8" height="8"/><rect x="166" y="174" width="8" height="8"/>
                                    </g>
                                </svg>
                            </div>

                            <div class="qr-caption">
                                Scan QR di atas menggunakan aplikasi <strong>e-wallet</strong> atau <strong>m-banking</strong> Anda
                            </div>
                            <span class="qr-badge"><i class="fas fa-clock"></i> Berlaku 15 menit</span>

                        </div>

                        <!-- Virtual Account Panel -->
                        <div class="pay-detail-panel" id="panel_va">

                            <div class="va-bank-row">
                                <div class="va-bank-logo">VA</div>
                                <div style="text-align:left;">
                                    <div style="font-weight:600;font-size:.9rem;">Bank Virtual Account</div>
                                    <div style="font-size:.78rem;color:var(--gray);">a.n. Museum Listrik dan Energi Baru</div>
                                </div>
                            </div>

                            <div class="va-number-box">
                                <span class="va-num" id="vaNumber">8881-0234-5678-90</span>
                                <button type="button" class="va-copy-btn" onclick="copyVA()">
                                    <i class="fas fa-copy"></i> Salin
                                </button>
                            </div>

                            <ol class="pay-steps">
                                <li>Buka aplikasi m-banking atau kunjungi ATM terdekat</li>
                                <li>Pilih menu <strong>Transfer &rarr; Virtual Account</strong></li>
                                <li>Masukkan nomor VA di atas, lalu konfirmasi nominal</li>
                                <li>Selesaikan pembayaran sesuai instruksi pada aplikasi</li>
                            </ol>

                        </div>

                        <div class="pay-note">
                            <i class="fas fa-circle-info"></i>
                            <span>
                                Klik <strong>"Saya Sudah Membayar"</strong> setelah transaksi berhasil.
                                Tiket akan langsung terbit secara otomatis tanpa perlu menunggu verifikasi.
                            </span>
                        </div>

                        <button class="btn btn-success pay-confirm-btn mt-3">
                            <i class="fas fa-check"></i>
                            Saya Sudah Membayar
                        </button>

                    </form>

                </div>

            </div>

        @endif

    </div>

</div>

<script>
document.querySelectorAll('input[name="metode_pembayaran"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
        document.getElementById('panel_qris').classList.toggle('active', this.value === 'QRIS');
        document.getElementById('panel_va').classList.toggle('active', this.value === 'Virtual Account');
    });
});

function copyVA() {
    const number = document.getElementById('vaNumber').textContent.replace(/-/g, '');
    navigator.clipboard.writeText(number).then(function () {
        const btn = document.querySelector('.va-copy-btn');
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin';
        btn.classList.add('copied');
        setTimeout(function () {
            btn.innerHTML = original;
            btn.classList.remove('copied');
        }, 1800);
    });
}
</script>

@endsection