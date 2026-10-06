@extends('layouts.admin')
@section('title','Laporan Kunjungan')
@section('page-title','Laporan Kunjungan')
@section('breadcrumb')<li class="breadcrumb-item active">Laporan</li>@endsection

@section('content')
@php
$bulanNama = [
    '',
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];
@endphp

{{-- FILTER PERIODE --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <div class="d-flex align-items-center gap-2">
                <label class="small fw-semibold">Periode:</label>
                <select name="bulan" class="form-select form-select-sm" style="width:130px">
                    @foreach($bulanNama as $n => $nama)
                    @if($n > 0)<option value="{{ $n }}" {{ $bulan==$n?'selected':'' }}>{{ $nama }}</option>@endif
                    @endforeach
                </select>
                <select name="tahun" class="form-select form-select-sm" style="width:90px">
                    @foreach($tahunList as $t)<option value="{{ $t }}" {{ $tahun==$t?'selected':'' }}>{{ $t }}</option>@endforeach
                </select>
            </div>
            <select name="jenis" class="form-select form-select-sm" style="max-width:170px">
                <option value="">Semua Jenis</option>
                <option value="individu" {{ request('jenis')=='individu'?'selected':'' }}>Individu</option>
                <option value="keluarga" {{ request('jenis')=='keluarga'?'selected':'' }}>Keluarga</option>
                <option value="rombongan_sekolah" {{ request('jenis')=='rombongan_sekolah'?'selected':'' }}>Rombongan Sekolah</option>
                <option value="rombongan_instansi" {{ request('jenis')=='rombongan_instansi'?'selected':'' }}>Rombongan Instansi</option>
            </select>
            <select name="status" class="form-select form-select-sm" style="max-width:170px">
                <option value="">Semua Status</option>
                <option value="kunjungan_selesai" {{ request('status')=='kunjungan_selesai'?'selected':'' }}>Selesai</option>
                <option value="pembayaran_terkonfirmasi" {{ request('status')=='pembayaran_terkonfirmasi'?'selected':'' }}>Terkonfirmasi</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search me-1"></i>Tampilkan</button>
        </form>
    </div>
</div>

{{-- STATISTIK --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3"><div class="stat-card"><div class="stat-icon blue"><i class="bi bi-file-earmark-text-fill"></i></div><div><div class="stat-value">{{ $stats['total'] }}</div><div class="stat-label">Total Reservasi</div></div></div></div>
    <div class="col-sm-6 col-lg-3"><div class="stat-card"><div class="stat-icon green"><i class="bi bi-patch-check-fill"></i></div><div><div class="stat-value">{{ $stats['selesai'] }}</div><div class="stat-label">Kunjungan Selesai</div></div></div></div>
    <div class="col-sm-6 col-lg-3"><div class="stat-card"><div class="stat-icon purple"><i class="bi bi-people-fill"></i></div><div><div class="stat-value">{{ number_format($stats['total_peserta']) }}</div><div class="stat-label">Total Peserta</div></div></div></div>
    <div class="col-sm-6 col-lg-3"><div class="stat-card"><div class="stat-icon yellow"><i class="bi bi-currency-dollar"></i></div><div><div class="stat-value" style="font-size:1.1rem">Rp {{ number_format($stats['pendapatan'],0,',','.') }}</div><div class="stat-label">Pendapatan</div></div></div></div>
</div>

{{-- EXPORT PDF BUTTON --}}
<div class="admin-card mb-3">
    <div class="card-body py-2">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="fw-semibold small"><i class="bi bi-file-pdf me-2 text-danger"></i>Export Laporan PDF</span>
            <div class="d-flex gap-2 flex-wrap align-items-center ms-auto">
                <input type="text" id="namaManajer" class="form-control form-control-sm" style="max-width:200px" placeholder="Nama Manajer / Penandatangan">
                <input type="text" id="jabatanManajer" class="form-control form-control-sm" style="max-width:180px" placeholder="Jabatan" value="Manajer Museum">
                <button type="button" class="btn btn-danger btn-sm fw-semibold" onclick="exportPdf()">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Unduh PDF
                </button>
            </div>
        </div>
    </div>
</div>

{{-- TABEL LAPORAN --}}
<div class="admin-card">
    <div class="card-header">
        <span><i class="bi bi-table me-2 text-primary"></i>Laporan {{ $bulanNama[$bulan] }} {{ $tahun }}</span>
        <span class="text-muted small">{{ $reservasi->count() }} data</span>
    </div>
    
<div class="d-flex justify-content-between align-items-center mb-2 no-print">
    <input type="text" id="searchLaporan" class="form-control form-control-sm" style="max-width:260px" placeholder="Cari kode / nama pemesan...">
    <small class="text-muted" id="infoLaporan"></small>
</div>
<div class="table-responsive">
        <table class="table mb-0" id="tblLaporan">
            <thead>
                <tr>
                    <th>#</th><th>Kode</th><th>Nama Pemesan</th><th>Tgl Kunjungan</th>
                    <th>Jenis</th><th>Sesi</th><th class="text-center">Peserta</th>
                    <th class="text-end">Total</th><th>Status</th><th>Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasi as $i => $r)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td class="small fw-semibold" style="color:var(--mleb-primary)">{{ $r->kode_reservasi }}</td>
                    <td class="small">{{ $r->nama_pemesan }}</td>
                    <td class="small">{{ $r->tanggal_kunjungan->format('d/m/Y') }}</td>
                    <td><span class="badge bg-light text-dark border" style="font-size:.7rem">{{ $r->label_jenis }}</span></td>
                    <td class="small">{{ $r->jadwal->nama_sesi }}</td>
                    <td class="text-center small">{{ $r->jumlah_peserta }}</td>
                    <td class="text-end small fw-semibold">Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                    <td>
                        @php $cls=match($r->status){'menunggu_pembayaran'=>['warning','dark'],'pembayaran_terkonfirmasi'=>['info','white'],'kunjungan_selesai'=>['success','white'],'dibatalkan'=>['danger','white'],default=>['secondary','white']}; @endphp
                        <span class="badge bg-{{ $cls[0] }} text-{{ $cls[1] }}" style="font-size:.7rem">{{ $r->label_status }}</span>
                    </td>
                    <td>
                        @if($r->pembayaran)
                        @php $ps=match($r->pembayaran->status){'menunggu'=>['warning','dark'],'terkonfirmasi'=>['success','white'],default=>['secondary','white']}; @endphp
                        <span class="badge bg-{{ $ps[0] }} text-{{ $ps[1] }}" style="font-size:.7rem">{{ $r->pembayaran->label_metode }}</span>
                        @else <span class="text-muted small">-</span> @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center py-4 text-muted">Tidak ada data untuk periode ini</td></tr>
                @endforelse
            </tbody>
            @if($reservasi->count())
            <tfoot>
                <tr class="table-light fw-bold">
                    <td colspan="6" class="text-end">TOTAL</td>
                    <td class="text-center">{{ $reservasi->sum('jumlah_peserta') }}</td>
                    <td class="text-end">Rp {{ number_format($reservasi->sum('total_harga'),0,',','.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportPdf() {
    var nama    = document.getElementById('namaManajer').value;
    var jabatan = document.getElementById('jabatanManajer').value;
    if (!nama) { Swal.fire('Perhatian','Masukkan nama manajer/penandatangan terlebih dahulu.','warning'); return; }
    var params = new URLSearchParams(window.location.search);
    params.set('nama_manajer', nama);
    params.set('jabatan', jabatan);
    window.open('/admin/laporan/export-pdf?' + params.toString(), '_blank');
}

// Search untuk tabel laporan (tanpa DataTables agar tfoot aman)
$(document).ready(function () {
    var $input = $('#searchLaporan');
    var $rows  = $('#tblLaporan tbody tr');
    var $info  = $('#infoLaporan');

    function updateInfo() {
        var visible = $rows.filter(':visible').length;
        $info.text(visible + ' dari ' + $rows.length + ' data');
    }

    $input.on('input', function () {
        var q = $(this).val().toLowerCase().trim();
        $rows.each(function () {
            var text = $(this).text().toLowerCase();
            $(this).toggle(!q || text.indexOf(q) !== -1);
        });
        updateInfo();
    });

    updateInfo();
});
</script>
@endpush
