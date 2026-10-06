@extends('layouts.admin')
@section('title','Data Pembayaran')
@section('page-title','Data Pembayaran')
@section('breadcrumb')<li class="breadcrumb-item active">Pembayaran</li>@endsection

@section('content')
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="status" class="form-select form-select-sm" style="max-width:180px">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status')=='menunggu'?'selected':'' }}>Menunggu</option>
                <option value="terkonfirmasi" {{ request('status')=='terkonfirmasi'?'selected':'' }}>Terkonfirmasi</option>
                <option value="expired" {{ request('status')=='expired'?'selected':'' }}>Expired</option>
                <option value="dibatalkan" {{ request('status')=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
            </select>
            <select name="metode" class="form-select form-select-sm" style="max-width:180px">
                <option value="">Semua Metode</option>
                <option value="bca_va" {{ request('metode')=='bca_va'?'selected':'' }}>VA BCA</option>
                <option value="mandiri_va" {{ request('metode')=='mandiri_va'?'selected':'' }}>VA Mandiri</option>
                <option value="bni_va" {{ request('metode')=='bni_va'?'selected':'' }}>VA BNI</option>
                <option value="bri_va" {{ request('metode')=='bri_va'?'selected':'' }}>VA BRI</option>
                <option value="qris" {{ request('metode')=='qris'?'selected':'' }}>QRIS</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search me-1"></i>Filter</button>
            @if(request()->hasAny(['status','metode']))<a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>@endif
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-credit-card me-2 text-primary"></i>Daftar Pembayaran</span>
        <span class="text-muted small">{{ $pembayaran->total() }} data</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-pembayaran" class="table mb-0">
            <thead>
                <tr><th>#</th><th>Kode Reservasi</th><th>Pengunjung</th><th>Metode</th><th>Total</th><th>Status</th><th>Tgl Konfirmasi</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($pembayaran as $i => $p)
                <tr>
                    <td>{{ $pembayaran->firstItem() + $i }}</td>
                    <td class="small fw-semibold" style="color:var(--mleb-primary)">{{ $p->reservasi->kode_reservasi ?? '-' }}</td>
                    <td class="small">{{ $p->reservasi->user->name ?? '-' }}</td>
                    <td class="small">{{ $p->label_metode }}</td>
                    <td class="small fw-semibold">Rp {{ number_format($p->total,0,',','.') }}</td>
                    <td>
                        @php $cls=match($p->status){'menunggu'=>['warning','dark'],'terkonfirmasi'=>['success','white'],'expired'=>['secondary','white'],'dibatalkan'=>['danger','white'],default=>['secondary','white']}; @endphp
                        <span class="badge bg-{{ $cls[0] }} text-{{ $cls[1] }}" style="font-size:.72rem">{{ ucfirst($p->status) }}</span>
                    </td>
                    <td class="small">{{ $p->dikonfirmasi_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td><a href="{{ route('admin.pembayaran.show',$p->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $pembayaran->links() }}</div>
</div>
@endsection
