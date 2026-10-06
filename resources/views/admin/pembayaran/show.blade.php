@extends('layouts.admin')
@section('title','Detail Pembayaran')
@section('page-title','Detail Pembayaran')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.pembayaran.index') }}">Pembayaran</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row g-4">
<div class="col-lg-8">
    <div class="admin-card mb-4">
        <div class="card-header">
            <span><i class="bi bi-credit-card me-2 text-primary"></i>Informasi Pembayaran</span>
            @php $cls=match($pembayaran->status){'menunggu'=>['warning','dark'],'terkonfirmasi'=>['success','white'],'expired'=>['secondary','white'],'dibatalkan'=>['danger','white'],default=>['secondary','white']}; @endphp
            <span class="badge bg-{{ $cls[0] }} text-{{ $cls[1] }}">{{ ucfirst($pembayaran->status) }}</span>
        </div>
        <div class="card-body">
            <div class="row g-3 small">
                <div class="col-sm-6"><div class="text-muted mb-1">Kode Reservasi</div><div class="fw-semibold"><a href="{{ route('admin.reservasi.show',$pembayaran->reservasi->id) }}">{{ $pembayaran->reservasi->kode_reservasi }}</a></div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Pengunjung</div><div class="fw-semibold">{{ $pembayaran->reservasi->user->name }}</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Metode Pembayaran</div><div class="fw-semibold">{{ $pembayaran->label_metode }}</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Total</div><div class="fw-bold fs-6" style="color:var(--mleb-primary)">Rp {{ number_format($pembayaran->total,0,',','.') }}</div></div>
                @if($pembayaran->nomor_va)
                <div class="col-sm-6"><div class="text-muted mb-1">Nomor VA</div><div class="fw-bold" style="font-family:monospace;letter-spacing:2px">{{ $pembayaran->nomor_va }}</div></div>
                @endif
                @if($pembayaran->kode_qris)
                <div class="col-sm-6"><div class="text-muted mb-1">Kode QRIS</div><div class="fw-semibold small">{{ $pembayaran->kode_qris }}</div></div>
                @endif
                <div class="col-sm-6"><div class="text-muted mb-1">Batas Pembayaran</div><div class="fw-semibold">{{ $pembayaran->expired_at?->format('d/m/Y H:i') ?? '-' }}</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Dikonfirmasi Pada</div><div class="fw-semibold">{{ $pembayaran->dikonfirmasi_at?->format('d/m/Y H:i') ?? '-' }}</div></div>
                @if($pembayaran->catatan_admin)
                <div class="col-12"><div class="text-muted mb-1">Catatan Admin</div><div class="fw-semibold">{{ $pembayaran->catatan_admin }}</div></div>
                @endif
            </div>
        </div>
    </div>

    {{-- Ringkasan pesanan --}}
    <div class="admin-card">
        <div class="card-header"><i class="bi bi-receipt me-2 text-primary"></i>Detail Pesanan</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Tiket</th><th>Tipe</th><th class="text-center">Jml</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
                <tbody>
                    @foreach($pembayaran->reservasi->detail as $d)
                    <tr>
                        <td>{{ $d->nama_item }}</td>
                        <td><span class="badge bg-light text-dark border" style="font-size:.7rem">{{ $d->tipe_item }}</span></td>
                        <td class="text-center">{{ $d->jumlah }}</td>
                        <td class="text-end">Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
                        <td class="text-end fw-semibold">Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot><tr class="table-light"><td colspan="4" class="fw-bold text-end">Total</td><td class="fw-bold text-end" style="color:var(--mleb-primary)">Rp {{ number_format($pembayaran->total,0,',','.') }}</td></tr></tfoot>
            </table>
        </div>
    </div>
</div>

<div class="col-lg-4">
    @if($pembayaran->status === 'menunggu')
    <div class="admin-card mb-3">
        <div class="card-header"><i class="bi bi-check-circle me-2 text-success"></i>Konfirmasi Pembayaran</div>
        <div class="card-body">
            <div class="alert alert-info py-2 small mb-3">
                <i class="bi bi-info-circle me-1"></i>
                Konfirmasi pembayaran akan otomatis membuat tiket digital untuk pengunjung.
            </div>
            <form action="{{ route('admin.pembayaran.konfirmasi',$pembayaran->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small">Catatan Admin (opsional)</label>
                    <textarea name="catatan_admin" class="form-control form-control-sm" rows="2" placeholder="Catatan tambahan..."></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-semibold mb-2"
                    data-confirm="Konfirmasi pembayaran Rp {{ number_format($pembayaran->total,0,',','.') }} ini?">
                    <i class="bi bi-check-circle me-2"></i>Konfirmasi Pembayaran
                </button>
            </form>
            <form action="{{ route('admin.pembayaran.tolak',$pembayaran->id) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <textarea name="catatan_admin" class="form-control form-control-sm" rows="2" placeholder="Alasan penolakan (wajib diisi)..." required></textarea>
                </div>
                <button type="submit" class="btn btn-danger w-100" data-confirm="Tolak pembayaran ini?">
                    <i class="bi bi-x-circle me-2"></i>Tolak Pembayaran
                </button>
            </form>
        </div>
    </div>
    @elseif($pembayaran->status === 'terkonfirmasi')
    <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i>Pembayaran telah dikonfirmasi.</div>
    @elseif($pembayaran->status === 'dibatalkan')
    <div class="alert alert-danger"><i class="bi bi-x-circle-fill me-2"></i>Pembayaran ditolak/dibatalkan.</div>
    @endif

    <div class="admin-card">
        <div class="card-body d-grid gap-2">
            <a href="{{ route('admin.reservasi.show',$pembayaran->reservasi->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-file-earmark-text me-2"></i>Lihat Reservasi
            </a>
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
</div>
@endsection
