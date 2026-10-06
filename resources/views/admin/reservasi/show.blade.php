@extends('layouts.admin')
@section('title','Detail Reservasi')
@section('page-title','Detail Reservasi')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reservasi.index') }}">Reservasi</a></li>
<li class="breadcrumb-item active">{{ $reservasi->kode_reservasi }}</li>
@endsection

@section('content')
<div class="row g-4">
<div class="col-lg-8">

    <div class="admin-card mb-4">
        <div class="card-header">
            <span><i class="bi bi-file-earmark-text me-2 text-primary"></i>{{ $reservasi->kode_reservasi }}</span>
            @php $cls=match($reservasi->status){'menunggu_pembayaran'=>['warning','dark'],'pembayaran_terkonfirmasi'=>['info','white'],'kunjungan_selesai'=>['success','white'],'dibatalkan'=>['danger','white'],default=>['secondary','white']}; @endphp
            <span class="badge bg-{{ $cls[0] }} text-{{ $cls[1] }}">{{ $reservasi->label_status }}</span>
        </div>
        <div class="card-body">
            <div class="row g-3 small">
                <div class="col-sm-6"><div class="text-muted mb-1">Nama Pemesan</div><div class="fw-semibold">{{ $reservasi->nama_pemesan }}</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Email</div><div class="fw-semibold">{{ $reservasi->email_pemesan }}</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">WhatsApp</div><div class="fw-semibold">{{ $reservasi->phone_pemesan }}</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Jenis Kunjungan</div><div class="fw-semibold">{{ $reservasi->label_jenis }}</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Tanggal Kunjungan</div><div class="fw-semibold">{{ $reservasi->tanggal_kunjungan->translatedFormat('l, d F Y') }}</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Sesi</div><div class="fw-semibold">{{ $reservasi->jadwal->nama_sesi }} ({{ $reservasi->jadwal->jam }})</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Jumlah Peserta</div><div class="fw-semibold">{{ $reservasi->jumlah_peserta }} orang</div></div>
                <div class="col-sm-6"><div class="text-muted mb-1">Tipe Hari</div><div class="fw-semibold">{{ ucfirst($reservasi->tipe_hari) }}</div></div>
                @if($reservasi->nama_sekolah)<div class="col-sm-6"><div class="text-muted mb-1">Sekolah</div><div class="fw-semibold">{{ $reservasi->nama_sekolah }}</div></div>@endif
                @if($reservasi->nama_guru_pendamping)<div class="col-sm-6"><div class="text-muted mb-1">Guru Pendamping</div><div class="fw-semibold">{{ $reservasi->nama_guru_pendamping }}</div></div>@endif
                @if($reservasi->nama_instansi)<div class="col-sm-6"><div class="text-muted mb-1">Instansi</div><div class="fw-semibold">{{ $reservasi->nama_instansi }}</div></div>@endif
                @if($reservasi->catatan_khusus)<div class="col-12"><div class="text-muted mb-1">Catatan Khusus</div><div class="fw-semibold">{{ $reservasi->catatan_khusus }}</div></div>@endif
            </div>
        </div>
    </div>

    <div class="admin-card mb-4">
        <div class="card-header"><i class="bi bi-ticket me-2 text-primary"></i>Detail Tiket</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Tiket</th><th>Tipe</th><th class="text-center">Jml</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
                <tbody>
                    @foreach($reservasi->detail as $d)
                    <tr>
                        <td class="small">{{ $d->nama_item }}</td>
                        <td><span class="badge bg-light text-dark border" style="font-size:.7rem">{{ $d->tipe_item }}</span></td>
                        <td class="text-center small">{{ $d->jumlah }}</td>
                        <td class="text-end small">Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
                        <td class="text-end small fw-semibold">Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot><tr class="table-light"><td colspan="4" class="fw-bold text-end">Total</td><td class="fw-bold text-end" style="color:var(--mleb-primary)">Rp {{ number_format($reservasi->total_harga,0,',','.') }}</td></tr></tfoot>
            </table>
        </div>
    </div>

    @if($reservasi->pembayaran)
    <div class="admin-card">
        <div class="card-header"><i class="bi bi-credit-card me-2 text-primary"></i>Info Pembayaran</div>
        <div class="card-body small">
            <div class="row g-2">
                <div class="col-sm-4"><div class="text-muted">Metode</div><div class="fw-semibold">{{ $reservasi->pembayaran->label_metode }}</div></div>
                <div class="col-sm-4"><div class="text-muted">Status</div>
                    @php $ps=match($reservasi->pembayaran->status){'menunggu'=>['warning','dark'],'terkonfirmasi'=>['success','white'],'expired'=>['secondary','white'],'dibatalkan'=>['danger','white'],default=>['secondary','white']}; @endphp
                    <span class="badge bg-{{ $ps[0] }} text-{{ $ps[1] }}">{{ ucfirst($reservasi->pembayaran->status) }}</span>
                </div>
                <div class="col-sm-4"><div class="text-muted">Dikonfirmasi</div><div class="fw-semibold">{{ $reservasi->pembayaran->dikonfirmasi_at?->format('d/m/Y H:i') ?? '-' }}</div></div>
            </div>
        </div>
    </div>
    @endif

</div>
<div class="col-lg-4">
    <div class="admin-card mb-3">
        <div class="card-header"><i class="bi bi-gear me-2"></i>Aksi</div>
        <div class="card-body d-grid gap-2">
            @if($reservasi->status === 'pembayaran_terkonfirmasi')
            <form action="{{ route('admin.reservasi.selesai',$reservasi->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success w-100" data-confirm="Tandai kunjungan ini sebagai selesai?">
                    <i class="bi bi-check-circle me-2"></i>Tandai Selesai
                </button>
            </form>
            @endif
            @if(!in_array($reservasi->status,['dibatalkan','kunjungan_selesai']))
            <form action="{{ route('admin.reservasi.batal',$reservasi->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100" data-confirm="Batalkan reservasi ini?">
                    <i class="bi bi-x-circle me-2"></i>Batalkan Reservasi
                </button>
            </form>
            @endif
            @if($reservasi->pembayaran && $reservasi->pembayaran->status === 'menunggu')
            <a href="{{ route('admin.pembayaran.show',$reservasi->pembayaran->id) }}" class="btn btn-warning w-100">
                <i class="bi bi-credit-card me-2"></i>Konfirmasi Pembayaran
            </a>
            @endif
            @if($reservasi->tiketDigital)
            <a href="{{ route('admin.tiket.show',$reservasi->tiketDigital->id) }}" class="btn btn-outline-primary w-100">
                <i class="bi bi-qr-code me-2"></i>Lihat Tiket Digital
            </a>
            @endif
            <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
</div>
@endsection
