@extends('layouts.app')
@section('title', 'Status Pembayaran')
@section('content')
<div class="container py-5">
    <a href="{{ route('reservasi.show', $reservasi->kode_reservasi) }}" class="link-secondary small"><i class="bi bi-arrow-left"></i> Kembali</a>

    <div class="card shadow-sm mt-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                <h4 class="fw-bold">Pembayaran {{ $pembayaran->kode_pembayaran }}</h4>
                <span class="badge bg-{{ $pembayaran->status_color }} fs-6 px-3 py-2">{{ $pembayaran->status_label }}</span>
            </div>

            <p><strong>Total Pembayaran:</strong> <span class="text-warning fw-bold fs-5">Rp {{ number_format($pembayaran->jumlah_bayar,0,',','.') }}</span></p>
            <p><strong>Batas Waktu Pembayaran:</strong> {{ $pembayaran->batas_waktu_pembayaran->translatedFormat('d F Y, H:i') }} WIB</p>

            <hr>

            @if($pembayaran->metode_pembayaran === 'qris')
                <div class="text-center">
                    <h5 class="mb-3"><i class="bi bi-qr-code-scan"></i> Scan QRIS Berikut</h5>
                    <div class="d-inline-block p-3 bg-white border rounded">
                        {!! QrCode::size(230)->generate($pembayaran->kode_pembayaran) !!}
                    </div>
                    <p class="text-muted small mt-2">Simulasi QRIS — kode referensi: {{ $pembayaran->kode_pembayaran }}</p>
                </div>
            @else
                <div class="text-center">
                    <h5 class="mb-3"><i class="bi bi-bank"></i> Transfer ke Virtual Account</h5>
                    <p class="mb-1 text-muted">Bank {{ $pembayaran->bank_va }}</p>
                    <h2 class="fw-bold tracking-wide">{{ $pembayaran->nomor_va }}</h2>
                    <p class="text-muted small">Salin nomor di atas dan lakukan transfer melalui ATM/mobile banking {{ $pembayaran->bank_va }}.</p>
                </div>
            @endif

            <hr>
            @if($pembayaran->status === 'menunggu_pembayaran')
                <form action="{{ route('pembayaran.konfirmasi', $reservasi->kode_reservasi) }}" method="POST" onsubmit="return confirm('Pastikan Anda sudah benar-benar melakukan pembayaran.')">
                    @csrf
                    <button class="btn btn-success btn-lg fw-semibold w-100"><i class="bi bi-check2-circle"></i> Saya Sudah Membayar</button>
                </form>
            @elseif($pembayaran->status === 'menunggu_verifikasi')
                <div class="alert alert-info mb-0"><i class="bi bi-hourglass-split"></i> Konfirmasi pembayaran Anda sedang diverifikasi oleh petugas museum.</div>
            @elseif($pembayaran->status === 'lunas')
                <div class="alert alert-success mb-3"><i class="bi bi-check-circle-fill"></i> Pembayaran berhasil diverifikasi!</div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('invoice.download', $reservasi->kode_reservasi) }}" target="_blank" class="btn btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i> Unduh Invoice PDF</a>
                    <a href="{{ route('tiket.show', $reservasi->kode_reservasi) }}" class="btn btn-success"><i class="bi bi-ticket-perforated"></i> Lihat E-Tiket Saya</a>
                </div>
            @elseif($pembayaran->status === 'gagal')
                <div class="alert alert-danger mb-0">Pembayaran ditandai gagal oleh petugas. {{ $pembayaran->catatan_admin }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
