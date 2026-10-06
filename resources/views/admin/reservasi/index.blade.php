@extends('layouts.admin')
@section('title','Data Reservasi')
@section('page-title','Data Reservasi')
@section('breadcrumb')<li class="breadcrumb-item active">Reservasi</li>@endsection

@section('content')
{{-- FILTER --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <input type="text" name="search" class="form-control form-control-sm" style="max-width:200px" placeholder="Cari kode / nama..." value="{{ request('search') }}">
            <select name="status" class="form-select form-select-sm" style="max-width:180px">
                <option value="">Semua Status</option>
                <option value="menunggu_pembayaran" {{ request('status')=='menunggu_pembayaran'?'selected':'' }}>Menunggu Pembayaran</option>
                <option value="pembayaran_terkonfirmasi" {{ request('status')=='pembayaran_terkonfirmasi'?'selected':'' }}>Terkonfirmasi</option>
                <option value="kunjungan_selesai" {{ request('status')=='kunjungan_selesai'?'selected':'' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status')=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
            </select>
            <select name="jenis" class="form-select form-select-sm" style="max-width:180px">
                <option value="">Semua Jenis</option>
                <option value="individu" {{ request('jenis')=='individu'?'selected':'' }}>Individu</option>
                <option value="keluarga" {{ request('jenis')=='keluarga'?'selected':'' }}>Keluarga</option>
                <option value="rombongan_sekolah" {{ request('jenis')=='rombongan_sekolah'?'selected':'' }}>Rombongan Sekolah</option>
                <option value="rombongan_instansi" {{ request('jenis')=='rombongan_instansi'?'selected':'' }}>Rombongan Instansi</option>
            </select>
            <input type="date" name="tanggal" class="form-control form-control-sm" style="max-width:160px" value="{{ request('tanggal') }}">
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search me-1"></i>Filter</button>
            @if(request()->hasAny(['search','status','jenis','tanggal']))
            <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-file-earmark-text me-2 text-primary"></i>Daftar Reservasi</span>
        <span class="text-muted small">{{ $reservasi->total() }} data</span>
    </div>
    <div class="table-responsive">
        <table id="tbl-reservasi" class="table mb-0">
            <thead>
                <tr>
                    <th>#</th><th>Kode</th><th>Pengunjung</th><th>Tgl Kunjungan</th>
                    <th>Jenis</th><th>Peserta</th><th>Total</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasi as $i => $r)
                <tr>
                    <td>{{ $reservasi->firstItem() + $i }}</td>
                    <td class="fw-semibold small" style="color:var(--mleb-primary)">{{ $r->kode_reservasi }}</td>
                    <td>
                        <div class="fw-semibold small">{{ $r->nama_pemesan }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $r->user->email }}</div>
                    </td>
                    <td class="small">{{ $r->tanggal_kunjungan->format('d/m/Y') }}<div class="text-muted" style="font-size:.72rem">{{ $r->jadwal->nama_sesi }}</div></td>
                    <td><span class="badge bg-light text-dark border" style="font-size:.72rem">{{ $r->label_jenis }}</span></td>
                    <td class="text-center small">{{ $r->jumlah_peserta }}</td>
                    <td class="small fw-semibold">Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                    <td>
                        @php $cls = match($r->status){'menunggu_pembayaran'=>['warning','dark'],'pembayaran_terkonfirmasi'=>['info','white'],'kunjungan_selesai'=>['success','white'],'dibatalkan'=>['danger','white'],default=>['secondary','white']}; @endphp
                        <span class="badge bg-{{ $cls[0] }} text-{{ $cls[1] }}" style="font-size:.7rem">{{ $r->label_status }}</span>
                    </td>
                    <td><a href="{{ route('admin.reservasi.show',$r->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada data reservasi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $reservasi->links() }}</div>
</div>
@endsection
