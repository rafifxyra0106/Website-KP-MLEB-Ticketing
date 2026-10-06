@extends('layouts.app')
@section('title','Detail Pesanan')

@section('content')
<div class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-1"><li class="breadcrumb-item"><a href="{{ route('beranda') }}" class="text-white-50">Beranda</a></li><li class="breadcrumb-item"><a href="{{ route('riwayat') }}" class="text-white-50">Riwayat</a></li><li class="breadcrumb-item text-white active">Detail Pesanan</li></ol></nav>
        <h1><i class="bi bi-file-earmark-text me-2"></i>Detail Pesanan</h1>
        <p class="mb-0">{{ $reservasi->kode_reservasi }}</p>
    </div>
</div>

<section class="py-4">
<div class="container">
<div class="row g-4">

    <div class="col-lg-8">

        {{-- STATUS CARD --}}
        @php
            $statusColor = match($reservasi->status) {
                'menunggu_pembayaran'      => ['warning','clock','Menunggu Pembayaran'],
                'pembayaran_terkonfirmasi' => ['info','check-circle','Pembayaran Dikonfirmasi'],
                'kunjungan_selesai'        => ['success','patch-check-fill','Kunjungan Selesai'],
                'dibatalkan'               => ['danger','x-circle','Dibatalkan'],
                default                    => ['secondary','circle','Unknown'],
            };
        @endphp
        <div class="alert alert-{{ $statusColor[0] }} d-flex align-items-center gap-3 mb-4">
            <i class="bi bi-{{ $statusColor[1] }} fs-3 flex-shrink-0"></i>
            <div>
                <div class="fw-bold">{{ $statusColor[2] }}</div>
                <div class="small">
                    @if($reservasi->status === 'menunggu_pembayaran')
                        Selesaikan pembayaran untuk mendapatkan tiket digital Anda.
                    @elseif($reservasi->status === 'pembayaran_terkonfirmasi')
                        Tiket digital Anda sudah aktif. Tunjukkan tiket saat tiba di museum.
                    @elseif($reservasi->status === 'kunjungan_selesai')
                        Terima kasih telah berkunjung! Bagikan kesan Anda.
                    @else
                        Pesanan ini telah dibatalkan.
                    @endif
                </div>
                @if($reservasi->status === 'menunggu_pembayaran')
                <a href="{{ route('pembayaran.show', $reservasi->id) }}" class="btn btn-warning btn-sm mt-2 fw-semibold">
                    <i class="bi bi-credit-card me-1"></i>Selesaikan Pembayaran
                </a>
                @endif
            </div>
        </div>

        {{-- TIKET DIGITAL --}}
        @if($reservasi->tiketDigital && $reservasi->status !== 'dibatalkan')
        <div class="card-mleb card mb-4">
            <div class="card-header bg-success text-white" style="border-radius:14px 14px 0 0 !important">
                <i class="bi bi-qr-code me-2"></i><span class="fw-bold">Tiket Digital Anda</span>
            </div>
            <div class="card-body">
                <div class="tiket-digital-card">
                    <div class="tiket-header">
                        <div style="font-size:1.5rem font-weight:800">⚡ MLEB</div>
                        <div style="font-size:.85rem;opacity:.8">Museum Listrik dan Energi Baru</div>
                        <div class="mt-2 fw-bold fs-5">{{ $reservasi->nama_pemesan }}</div>
                    </div>
                    <div class="tiket-body">
                        <div class="text-center mb-3">
                            <div style="background:#f8f9fa;border:2px dashed #dee2e6;border-radius:12px;padding:1.5rem;display:inline-block">
                                <div style="font-size:3rem">📱</div>
                                <div class="small text-muted mt-1">QR Tiket</div>
                                <div style="font-size:.7rem;font-family:monospace;color:#6c757d;word-break:break-all;max-width:200px">
                                    {{ $reservasi->tiketDigital->kode_tiket }}
                                </div>
                            </div>
                        </div>
                        <div class="tiket-divider"><div class="tiket-circle left"></div><div class="tiket-circle right"></div></div>
                        <table class="w-100 small mt-3">
                            <tr><td class="text-muted py-1" width="45%">Tanggal</td><td class="fw-semibold">{{ $reservasi->tanggal_kunjungan->translatedFormat('d F Y') }}</td></tr>
                            <tr><td class="text-muted py-1">Sesi</td><td class="fw-semibold">{{ $reservasi->jadwal->nama_sesi }}</td></tr>
                            <tr><td class="text-muted py-1">Jam</td><td class="fw-semibold">{{ $reservasi->jadwal->jam }} WIB</td></tr>
                            <tr><td class="text-muted py-1">Jenis</td><td class="fw-semibold">{{ $reservasi->label_jenis }}</td></tr>
                            <tr><td class="text-muted py-1">Peserta</td><td class="fw-semibold">{{ $reservasi->jumlah_peserta }} orang</td></tr>
                        </table>
                        <div class="tiket-divider mt-3"><div class="tiket-circle left"></div><div class="tiket-circle right"></div></div>
                        <div class="text-center mt-3">
                            <span class="badge bg-{{ $reservasi->tiketDigital->status === 'aktif' ? 'success' : 'secondary' }} px-3 py-2">
                                {{ strtoupper($reservasi->tiketDigital->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-3 flex-wrap">
                    <a href="{{ route('tiket.show', $reservasi->tiketDigital->kode_tiket) }}" class="btn btn-mleb">
                        <i class="bi bi-eye me-2"></i>Lihat Tiket
                    </a>
                    <a href="{{ route('tiket.cetak', $reservasi->tiketDigital->kode_tiket) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="bi bi-printer me-2"></i>Cetak Tiket PDF
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- DETAIL TIKET YANG DIPESAN --}}
        <div class="card-mleb card mb-4">
            <div class="card-header"><i class="bi bi-ticket me-2 text-primary"></i>Tiket yang Dipesan</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Nama Tiket</th><th class="text-center">Jml</th><th class="text-end">Harga Satuan</th><th class="text-end">Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($reservasi->detail as $d)
                        <tr>
                            <td>
                                <span class="badge bg-light text-secondary border me-1" style="font-size:.7rem">{{ $d->tipe_item }}</span>
                                {{ $d->nama_item }}
                            </td>
                            <td class="text-center">{{ $d->jumlah }}</td>
                            <td class="text-end small">Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="3" class="fw-bold text-end">Total Pembayaran</td>
                            <td class="fw-bold text-end fs-6" style="color:var(--mleb-primary)">Rp {{ number_format($reservasi->total_harga,0,',','.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- INFO KUNJUNGAN --}}
        <div class="card-mleb card mb-4">
            <div class="card-header"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Kunjungan</div>
            <div class="card-body">
                <div class="row g-3 small">
                    <div class="col-sm-6">
                        <div class="text-muted mb-1">Nama Pemesan</div>
                        <div class="fw-semibold">{{ $reservasi->nama_pemesan }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted mb-1">Email</div>
                        <div class="fw-semibold">{{ $reservasi->email_pemesan }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted mb-1">No. WhatsApp</div>
                        <div class="fw-semibold">{{ $reservasi->phone_pemesan }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted mb-1">Jenis Kunjungan</div>
                        <div class="fw-semibold">{{ $reservasi->label_jenis }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted mb-1">Jumlah Peserta</div>
                        <div class="fw-semibold">{{ $reservasi->jumlah_peserta }} orang</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted mb-1">Tipe Hari</div>
                        <div class="fw-semibold">{{ ucfirst($reservasi->tipe_hari) }}
                            @if($reservasi->tipe_hari === 'weekend')<span class="badge bg-warning text-dark ms-1">Harga Weekend</span>@endif
                        </div>
                    </div>
                    @if($reservasi->nama_sekolah)
                    <div class="col-sm-6"><div class="text-muted mb-1">Nama Sekolah</div><div class="fw-semibold">{{ $reservasi->nama_sekolah }}</div></div>
                    @endif
                    @if($reservasi->nama_guru_pendamping)
                    <div class="col-sm-6"><div class="text-muted mb-1">Guru Pendamping</div><div class="fw-semibold">{{ $reservasi->nama_guru_pendamping }}</div></div>
                    @endif
                    @if($reservasi->nama_instansi)
                    <div class="col-sm-6"><div class="text-muted mb-1">Instansi</div><div class="fw-semibold">{{ $reservasi->nama_instansi }}</div></div>
                    @endif
                </div>

                @if($reservasi->butuh_kursi_roda || $reservasi->butuh_pemandu || $reservasi->ada_balita || $reservasi->catatan_khusus)
                <hr class="my-3">
                <div class="small">
                    <div class="text-muted fw-semibold mb-2">Kebutuhan Khusus:</div>
                    @if($reservasi->butuh_kursi_roda)<div class="mb-1">♿ Kursi roda: <strong>{{ $reservasi->jumlah_kursi_roda }} unit</strong></div>@endif
                    @if($reservasi->butuh_pemandu)<div class="mb-1">🎙️ Pemandu ({{ $reservasi->bahasa_pemandu }})</div>@endif
                    @if($reservasi->ada_balita)<div class="mb-1">👶 Balita: <strong>{{ $reservasi->jumlah_balita }} orang</strong></div>@endif
                    @if($reservasi->catatan_khusus)<div class="mb-1">📝 {{ $reservasi->catatan_khusus }}</div>@endif
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- SIDEBAR KANAN --}}
    <div class="col-lg-4">
        <div class="card-mleb card mb-3">
            <div class="card-header"><i class="bi bi-calendar3 me-2 text-primary"></i>Jadwal Kunjungan</div>
            <div class="card-body text-center py-4">
                <div class="fw-bold fs-4 mb-1" style="color:var(--mleb-primary)">
                    {{ $reservasi->tanggal_kunjungan->format('d') }}
                </div>
                <div class="fw-semibold text-muted">{{ $reservasi->tanggal_kunjungan->translatedFormat('F Y') }}</div>
                <hr>
                <div class="fw-bold">{{ $reservasi->jadwal->nama_sesi }}</div>
                <div class="text-muted small">{{ $reservasi->jadwal->jam }} WIB</div>
            </div>
        </div>

        <div class="card-mleb card mb-3">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('reservasi.invoice', $reservasi->id) }}" class="btn btn-mleb" target="_blank">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Download Invoice PDF
                    </a>
                    @if($reservasi->status === 'menunggu_pembayaran')
                    <a href="{{ route('pembayaran.show', $reservasi->id) }}" class="btn btn-warning fw-semibold">
                        <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                    </a>
                    @endif
                    @if($reservasi->status === 'kunjungan_selesai' && !$reservasi->kesan)
                    <a href="{{ route('kesan.create') }}" class="btn btn-outline-warning">
                        <i class="bi bi-star me-2"></i>Beri Ulasan
                    </a>
                    @endif
                    <a href="{{ route('riwayat') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</section>
@endsection
