@extends('layouts.app')
@section('title','Tiket Digital')

@section('content')
<div class="page-header">
    <div class="container text-center">
        <h1><i class="bi bi-qr-code me-2"></i>Tiket Digital</h1>
        <p class="mb-0">Tunjukkan tiket ini kepada petugas di pintu masuk museum</p>
    </div>
</div>

<section class="py-5">
<div class="container" style="max-width:480px">

    @if($tiket->status === 'aktif')
    <div class="alert alert-success d-flex gap-2 align-items-center mb-4">
        <i class="bi bi-check-circle-fill fs-5 flex-shrink-0"></i>
        <div><strong>Tiket Aktif</strong> — Tunjukkan halaman ini kepada petugas museum.</div>
    </div>
    @elseif($tiket->status === 'digunakan')
    <div class="alert alert-secondary d-flex gap-2 align-items-center mb-4">
        <i class="bi bi-check-all fs-5 flex-shrink-0"></i>
        <div><strong>Tiket Sudah Digunakan</strong> pada {{ $tiket->digunakan_at?->format('d/m/Y H:i') }}</div>
    </div>
    @endif

    <div class="tiket-digital-card shadow-lg">
        {{-- Header --}}
        <div class="tiket-header">
            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                <span style="font-size:1.6rem">⚡</span>
                <div>
                    <div class="fw-bold fs-5">MLEB</div>
                    <div style="font-size:.72rem;opacity:.75">Museum Listrik dan Energi Baru</div>
                </div>
            </div>
            <div class="fw-bold" style="font-size:1.1rem">{{ $tiket->reservasi->nama_pemesan }}</div>
            <div style="font-size:.78rem;opacity:.75">{{ $tiket->reservasi->label_jenis }}</div>
        </div>

        {{-- Body --}}
        <div class="tiket-body">
            {{-- QR Code area --}}
            <div class="text-center mb-4">
                <div style="background:#f8f9fa;border:2px solid #e2e8f0;border-radius:14px;padding:1.5rem;display:inline-block">
                    <div style="font-size:5rem;line-height:1">📱</div>
                    <div class="small text-muted mt-2" style="font-size:.7rem">KODE TIKET</div>
                    <div style="font-family:monospace;font-size:.75rem;font-weight:700;color:#374151;word-break:break-all;max-width:200px;margin:0 auto">
                        {{ $tiket->kode_tiket }}
                    </div>
                </div>
            </div>

            <div class="tiket-divider"><div class="tiket-circle left"></div><div class="tiket-circle right"></div></div>

            {{-- Detail --}}
            <table class="w-100 mt-3" style="font-size:.85rem">
                <tr>
                    <td class="text-muted py-2" style="width:45%">📅 Tanggal</td>
                    <td class="fw-semibold">{{ $tiket->reservasi->tanggal_kunjungan->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td class="text-muted py-2">⏰ Sesi</td>
                    <td class="fw-semibold">{{ $tiket->reservasi->jadwal->nama_sesi }}</td>
                </tr>
                <tr>
                    <td class="text-muted py-2">🕐 Jam</td>
                    <td class="fw-semibold">{{ $tiket->reservasi->jadwal->jam }} WIB</td>
                </tr>
                <tr>
                    <td class="text-muted py-2">👥 Peserta</td>
                    <td class="fw-semibold">{{ $tiket->reservasi->jumlah_peserta }} orang</td>
                </tr>
            </table>

            <div class="tiket-divider mt-3"><div class="tiket-circle left"></div><div class="tiket-circle right"></div></div>

            {{-- Tiket list --}}
            <div class="mt-3">
                <div class="text-muted small fw-semibold mb-2">Tiket yang Dipesan:</div>
                @foreach($tiket->reservasi->detail as $d)
                <div class="d-flex justify-content-between py-1 small">
                    <span>{{ $d->nama_item }} × {{ $d->jumlah }}</span>
                    <span class="fw-semibold">Rp {{ number_format($d->subtotal,0,',','.') }}</span>
                </div>
                @endforeach
                <div class="d-flex justify-content-between pt-2 mt-1 border-top fw-bold small">
                    <span>Total</span>
                    <span style="color:var(--mleb-primary)">Rp {{ number_format($tiket->reservasi->total_harga,0,',','.') }}</span>
                </div>
            </div>

            <div class="tiket-divider mt-3"><div class="tiket-circle left"></div><div class="tiket-circle right"></div></div>

            <div class="text-center mt-3">
                <span class="badge px-3 py-2 {{ $tiket->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                    <i class="bi bi-{{ $tiket->status === 'aktif' ? 'check-circle' : 'check-all' }} me-1"></i>
                    {{ strtoupper($tiket->status) }}
                </span>
                <div class="text-muted mt-2" style="font-size:.7rem">Kode: {{ $tiket->reservasi->kode_reservasi }}</div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 justify-content-center mt-4 flex-wrap">
        <a href="{{ route('tiket.cetak', $tiket->kode_tiket) }}" class="btn btn-mleb" target="_blank">
            <i class="bi bi-printer me-2"></i>Cetak Tiket PDF
        </a>
        <a href="{{ route('reservasi.show', $tiket->reservasi_id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>
</section>
@endsection
