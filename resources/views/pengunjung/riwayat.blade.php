@extends('layouts.app')
@section('title','Riwayat Pesanan')

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-clock-history me-2"></i>Riwayat Pesanan</h1>
        <p class="mb-0">Daftar seluruh pesanan tiket kunjungan Anda</p>
    </div>
</div>

<section class="py-4">
<div class="container">

@forelse($reservasi as $r)
<div class="card-mleb card mb-3">
    <div class="card-body">
        <div class="row align-items-center g-3">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:48px;height:48px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">
                        🎫
                    </div>
                    <div>
                        <div class="fw-bold small" style="color:var(--mleb-primary)">{{ $r->kode_reservasi }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $r->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small text-muted mb-1">Tanggal Kunjungan</div>
                <div class="fw-semibold small">{{ $r->tanggal_kunjungan->translatedFormat('d F Y') }}</div>
                <div class="text-muted" style="font-size:.75rem">{{ $r->jadwal->nama_sesi }} • {{ $r->jadwal->jam }}</div>
            </div>
            <div class="col-md-2">
                <div class="small text-muted mb-1">Total</div>
                <div class="fw-bold" style="color:var(--mleb-primary)">Rp {{ number_format($r->total_harga,0,',','.') }}</div>
                <div class="text-muted" style="font-size:.75rem">{{ $r->jumlah_peserta }} peserta</div>
            </div>
            <div class="col-md-2">
                @php
                    $cls = match($r->status) {
                        'menunggu_pembayaran'      => 'status-menunggu',
                        'pembayaran_terkonfirmasi' => 'status-konfirmasi',
                        'kunjungan_selesai'        => 'status-selesai',
                        'dibatalkan'               => 'status-batal',
                        default                    => '',
                    };
                @endphp
                <span class="status-badge {{ $cls }}">{{ $r->label_status }}</span>
            </div>
            <div class="col-md-1 text-end">
                <div class="d-flex gap-1 justify-content-end flex-wrap">
                    <a href="{{ route('reservasi.show', $r->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    @if($r->status === 'menunggu_pembayaran')
                    <a href="{{ route('pembayaran.show', $r->id) }}" class="btn btn-sm btn-warning" title="Bayar">
                        <i class="bi bi-credit-card"></i>
                    </a>
                    @endif
                    @if($r->tiketDigital && in_array($r->status, ['pembayaran_terkonfirmasi','kunjungan_selesai']))
                    <a href="{{ route('tiket.show', $r->tiketDigital->kode_tiket) }}" class="btn btn-sm btn-success" title="Tiket">
                        <i class="bi bi-qr-code"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <div style="font-size:4rem;margin-bottom:1rem">🎫</div>
    <h5 class="fw-bold text-muted">Belum Ada Pesanan</h5>
    <p class="text-muted mb-4">Anda belum pernah memesan tiket kunjungan museum.</p>
    <a href="{{ route('reservasi.create') }}" class="btn btn-mleb btn-lg">
        <i class="bi bi-ticket-perforated me-2"></i>Pesan Tiket Sekarang
    </a>
</div>
@endforelse

@if($reservasi->hasPages())
<div class="mt-4">{{ $reservasi->links() }}</div>
@endif

</div>
</section>
@endsection
