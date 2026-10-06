@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-sm-6 col-xl-3">
        <div class="stat-card"><div class="stat-icon blue"><i class="bi bi-people-fill"></i></div><div><div class="stat-value">{{ number_format($stats['total_pengunjung']) }}</div><div class="stat-label">Total Pengunjung</div></div></div>
    </div>
    <div class="col-6 col-sm-6 col-xl-3">
        <div class="stat-card"><div class="stat-icon teal"><i class="bi bi-file-earmark-text-fill"></i></div><div><div class="stat-value">{{ number_format($stats['total_reservasi']) }}</div><div class="stat-label">Total Reservasi</div></div></div>
    </div>
    <div class="col-6 col-sm-6 col-xl-3">
        <div class="stat-card"><div class="stat-icon yellow"><i class="bi bi-clock-fill"></i></div><div><div class="stat-value">{{ $stats['menunggu_pembayaran'] }}</div><div class="stat-label">Menunggu Bayar</div></div></div>
    </div>
    <div class="col-6 col-sm-6 col-xl-3">
        <div class="stat-card"><div class="stat-icon purple"><i class="bi bi-patch-check-fill"></i></div><div><div class="stat-value">{{ $stats['terkonfirmasi'] }}</div><div class="stat-label">Terkonfirmasi</div></div></div>
    </div>
    <div class="col-6 col-sm-6 col-xl-4">
        <div class="stat-card"><div class="stat-icon green"><i class="bi bi-trophy-fill"></i></div><div><div class="stat-value">{{ $stats['kunjungan_selesai'] }}</div><div class="stat-label">Kunjungan Selesai</div></div></div>
    </div>
    <div class="col-6 col-sm-6 col-xl-4">
        <div class="stat-card"><div class="stat-icon green"><i class="bi bi-currency-dollar"></i></div><div><div class="stat-value" style="font-size:1.1rem">Rp {{ number_format($stats['pendapatan_bulan_ini'],0,',','.') }}</div><div class="stat-label">Pendapatan Bulan Ini</div></div></div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="stat-card"><div class="stat-icon red"><i class="bi bi-graph-up-arrow"></i></div><div><div class="stat-value" style="font-size:1.1rem">Rp {{ number_format($stats['total_pendapatan'],0,',','.') }}</div><div class="stat-label">Total Pendapatan</div></div></div>
    </div>
</div>

{{-- CHART + TABEL --}}
<div class="row g-4 mb-4 align-items-start">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Reservasi 7 Hari Terakhir</div>
            <div class="card-body">
                <div style="position:relative;height:300px">
                    <canvas id="chartReservasi"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header"><i class="bi bi-lightning-charge me-2 text-warning"></i>Aksi Cepat</div>
            <div class="card-body">
                <div class="quick-action-list">
                    <a href="{{ route('admin.reservasi.index', ['status'=>'menunggu_pembayaran']) }}" class="quick-action-item">
                        <div class="quick-action-icon warning"><i class="bi bi-clock"></i></div>
                        <div class="quick-action-text">
                            <div class="quick-action-title">Reservasi Menunggu</div>
                            <div class="quick-action-sub">{{ $stats['menunggu_pembayaran'] }} reservasi perlu ditindak</div>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('admin.pembayaran.index', ['status'=>'menunggu']) }}" class="quick-action-item">
                        <div class="quick-action-icon danger"><i class="bi bi-credit-card"></i></div>
                        <div class="quick-action-text">
                            <div class="quick-action-title">Pembayaran Perlu Dikonfirmasi</div>
                            <div class="quick-action-sub">Cek pembayaran masuk</div>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('admin.jadwal.create') }}" class="quick-action-item">
                        <div class="quick-action-icon primary"><i class="bi bi-plus-circle"></i></div>
                        <div class="quick-action-text">
                            <div class="quick-action-title">Tambah Jadwal Sesi</div>
                            <div class="quick-action-sub">Buat sesi kunjungan baru</div>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('admin.jenis-tiket.create') }}" class="quick-action-item">
                        <div class="quick-action-icon info"><i class="bi bi-ticket"></i></div>
                        <div class="quick-action-text">
                            <div class="quick-action-title">Tambah Jenis Tiket</div>
                            <div class="quick-action-sub">Kelola jenis tiket museum</div>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="quick-action-item">
                        <div class="quick-action-icon secondary"><i class="bi bi-bar-chart"></i></div>
                        <div class="quick-action-text">
                            <div class="quick-action-title">Lihat Laporan Bulan Ini</div>
                            <div class="quick-action-sub">Ringkasan performa museum</div>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RECENT TABLES --}}
<div class="row g-4">
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="card-header">
                <span><i class="bi bi-file-earmark-text me-2 text-primary"></i>Reservasi Terbaru</span>
                <a href="{{ route('admin.reservasi.index') }}" class="btn btn-sm btn-outline-primary">Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Kode</th><th>Pengunjung</th><th>Tgl Kunjungan</th><th>Total</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($reservasiTerbaru as $r)
                        <tr>
                            <td><a href="{{ route('admin.reservasi.show',$r->id) }}" class="fw-semibold small" style="color:var(--mleb-primary)">{{ $r->kode_reservasi }}</a></td>
                            <td class="small">{{ $r->user->name }}</td>
                            <td class="small">{{ $r->tanggal_kunjungan->format('d/m/Y') }}</td>
                            <td class="small">Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                            <td>
                                @php $cls = match($r->status){'menunggu_pembayaran'=>'warning','pembayaran_terkonfirmasi'=>'info','kunjungan_selesai'=>'success','dibatalkan'=>'danger',default=>'secondary'}; @endphp
                                <span class="badge bg-{{ $cls }} text-{{ in_array($cls,['warning']) ? 'dark' : 'white' }}" style="font-size:.7rem">{{ $r->label_status }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada reservasi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="card-header">
                <span><i class="bi bi-credit-card me-2 text-danger"></i>Pembayaran Menunggu Konfirmasi</span>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Pengunjung</th><th>Metode</th><th>Total</th><th></th></tr></thead>
                    <tbody>
                        @forelse($pembayaranMenunggu as $p)
                        <tr>
                            <td class="small">{{ $p->reservasi->user->name ?? '-' }}</td>
                            <td class="small">{{ $p->label_metode }}</td>
                            <td class="small fw-semibold">Rp {{ number_format($p->total,0,',','.') }}</td>
                            <td><a href="{{ route('admin.pembayaran.show',$p->id) }}" class="btn btn-xs btn-success" style="font-size:.72rem;padding:.2rem .5rem">Konfirmasi</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Tidak ada pembayaran menunggu</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('chartReservasi');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($grafikData, 'tanggal')) !!},
            datasets: [{
                label: 'Jumlah Reservasi',
                data: {!! json_encode(array_column($grafikData, 'jumlah')) !!},
                backgroundColor: 'rgba(15,52,96,.7)',
                borderColor: '#0f3460',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
}
</script>
@endpush
