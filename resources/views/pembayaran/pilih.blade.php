@extends('layouts.app')
@section('title', 'Pilih Metode Pembayaran')
@section('content')
<div class="container py-5">
    <a href="{{ route('reservasi.show', $reservasi->kode_reservasi) }}" class="link-secondary small"><i class="bi bi-arrow-left"></i> Kembali</a>
    <h2 class="section-title">Pemesanan Tiket — Pilih Metode Pembayaran</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p class="mb-1"><strong>Kode Reservasi:</strong> {{ $reservasi->kode_reservasi }}</p>
            <p class="mb-1"><strong>Jumlah Tiket:</strong> {{ $reservasi->jumlah_tiket }}</p>
            <p class="mb-0"><strong>Total Pembayaran:</strong> <span class="fs-5 text-warning fw-bold">Rp {{ number_format($reservasi->total_harga,0,',','.') }}</span></p>
        </div>
    </div>

    <form action="{{ route('pembayaran.buat', $reservasi->kode_reservasi) }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label class="payment-option-card">
                    <input type="radio" name="metode_pembayaran" value="qris" class="d-none metodeRadio" required>
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-qr-code-scan fs-1 text-warning"></i>
                        <h5 class="mt-2">QRIS</h5>
                        <p class="small text-muted mb-0">Bayar dengan scan QRIS dari aplikasi e-wallet/mobile banking apa saja.</p>
                    </div>
                </label>
            </div>
            <div class="col-md-6">
                <label class="payment-option-card">
                    <input type="radio" name="metode_pembayaran" value="virtual_account" class="d-none metodeRadio" required>
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-bank fs-1 text-warning"></i>
                        <h5 class="mt-2">Virtual Account</h5>
                        <p class="small text-muted mb-0">Transfer melalui nomor Virtual Account bank pilihan Anda.</p>
                    </div>
                </label>
            </div>
        </div>

        <div class="mt-4" id="pilihBank" style="display:none;">
            <label class="form-label">Pilih Bank Virtual Account</label>
            <select name="bank_va" class="form-select">
                @foreach($bankVa as $bank)
                    <option value="{{ $bank }}">{{ $bank }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-warning btn-lg fw-semibold mt-4 w-100">Lanjutkan Pembayaran</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.metodeRadio').forEach(radio => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.payment-option-card .card').forEach(c => c.classList.remove('border-warning', 'border-3'));
        this.closest('label').querySelector('.card').classList.add('border-warning', 'border-3');
        document.getElementById('pilihBank').style.display = this.value === 'virtual_account' ? 'block' : 'none';
    });
});
</script>
@endpush
