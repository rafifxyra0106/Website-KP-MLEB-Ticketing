@extends('layouts.admin')
@section('title','Detail Tiket')
@section('page-title','Detail Tiket Digital')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.tiket.index') }}">Tiket Digital</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection
@section('content')
<div class="row g-4">
<div class="col-lg-6">
    <div class="admin-card">
        <div class="card-header"><i class="bi bi-qr-code me-2 text-primary"></i>Informasi Tiket</div>
        <div class="card-body small">
            <table class="w-100">
                <tr><td class="text-muted py-2" width="45%">Kode Tiket</td><td class="fw-bold" style="font-family:monospace;font-size:.85rem">{{ $tiket->kode_tiket }}</td></tr>
                <tr><td class="text-muted py-2">Pengunjung</td><td class="fw-semibold">{{ $tiket->user->name }}</td></tr>
                <tr><td class="text-muted py-2">Kode Reservasi</td><td class="fw-semibold"><a href="{{ route('admin.reservasi.show',$tiket->reservasi->id) }}">{{ $tiket->reservasi->kode_reservasi }}</a></td></tr>
                <tr><td class="text-muted py-2">Tanggal Kunjungan</td><td class="fw-semibold">{{ $tiket->reservasi->tanggal_kunjungan->translatedFormat('l, d F Y') }}</td></tr>
                <tr><td class="text-muted py-2">Sesi</td><td class="fw-semibold">{{ $tiket->reservasi->jadwal->nama_sesi }} ({{ $tiket->reservasi->jadwal->jam }})</td></tr>
                <tr><td class="text-muted py-2">Peserta</td><td class="fw-semibold">{{ $tiket->reservasi->jumlah_peserta }} orang</td></tr>
                <tr><td class="text-muted py-2">Status</td><td><span class="badge bg-{{ $tiket->status==='aktif'?'success':'secondary' }}">{{ ucfirst($tiket->status) }}</span></td></tr>
                <tr><td class="text-muted py-2">Dibuat</td><td>{{ $tiket->created_at->format('d/m/Y H:i') }}</td></tr>
                <tr><td class="text-muted py-2">Digunakan</td><td>{{ $tiket->digunakan_at?->format('d/m/Y H:i') ?? '-' }}</td></tr>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="admin-card">
        <div class="card-header"><i class="bi bi-ticket me-2 text-primary"></i>Tiket yang Dipesan</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Item</th><th class="text-center">Jml</th><th class="text-end">Subtotal</th></tr></thead>
                <tbody>
                    @foreach($tiket->reservasi->detail as $d)
                    <tr><td>{{ $d->nama_item }}</td><td class="text-center">{{ $d->jumlah }}</td><td class="text-end">Rp {{ number_format($d->subtotal,0,',','.') }}</td></tr>
                    @endforeach
                </tbody>
                <tfoot><tr class="table-light"><td colspan="2" class="fw-bold text-end">Total</td><td class="fw-bold text-end" style="color:var(--mleb-primary)">Rp {{ number_format($tiket->reservasi->total_harga,0,',','.') }}</td></tr></tfoot>
            </table>
        </div>
    </div>
    <div class="mt-3"><a href="{{ route('admin.tiket.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a></div>
</div>
</div>
@endsection
