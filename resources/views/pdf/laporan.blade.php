<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'DejaVu Sans',sans-serif; font-size:9px; color:#1e293b; background:#fff; }
.page { padding:24px 28px; }

/* KOP SURAT */
.kop { display:table; width:100%; border-bottom:3px double #0f3460; padding-bottom:12px; margin-bottom:14px; }
.kop-left { display:table-cell; vertical-align:middle; width:15%; }
.kop-center { display:table-cell; vertical-align:middle; text-align:center; width:70%; }
.kop-right { display:table-cell; vertical-align:middle; text-align:right; width:15%; }
.kop-logo { display:inline-block; background:#0f3460; color:#f5a623; padding:8px 14px; border-radius:8px; font-size:18px; font-weight:900; }
.kop-title { font-size:14px; font-weight:900; color:#0f3460; margin-bottom:2px; }
.kop-subtitle { font-size:9px; color:#64748b; }
.kop-address { font-size:8px; color:#94a3b8; margin-top:2px; }

/* JUDUL LAPORAN */
.laporan-title-box { text-align:center; margin-bottom:14px; }
.laporan-title { font-size:12px; font-weight:900; text-transform:uppercase; letter-spacing:.06em; color:#0f3460; }
.laporan-subtitle { font-size:9px; color:#64748b; margin-top:2px; }

/* STATISTIK */
.stat-row { display:table; width:100%; margin-bottom:14px; border-collapse:separate; border-spacing:6px 0; }
.stat-box { display:table-cell; text-align:center; background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:8px 6px; width:25%; }
.stat-val { font-size:13px; font-weight:900; color:#0f3460; }
.stat-lbl { font-size:7.5px; color:#64748b; margin-top:2px; }

/* TABLE */
table.report { width:100%; border-collapse:collapse; margin-bottom:14px; }
table.report thead th { background:#0f3460; color:white; padding:5px 7px; font-size:8px; font-weight:700; text-align:left; }
table.report thead th.center { text-align:center; }
table.report thead th.right { text-align:right; }
table.report tbody td { padding:4px 7px; font-size:8px; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
table.report tbody tr:nth-child(even) td { background:#f8fafc; }
table.report tfoot td { background:#e8edf4; padding:5px 7px; font-size:8.5px; font-weight:700; border-top:2px solid #0f3460; }
.text-center { text-align:center; }
.text-right { text-align:right; }
.badge { display:inline-block; padding:2px 7px; border-radius:50px; font-size:7px; font-weight:700; }
.b-selesai { background:#d1fae5; color:#065f46; }
.b-konfirm { background:#dbeafe; color:#1e40af; }
.b-menunggu { background:#fef3c7; color:#92400e; }
.b-batal { background:#fee2e2; color:#991b1b; }
.b-individu { background:#e0e7ff; color:#3730a3; }
.b-keluarga { background:#ede9fe; color:#5b21b6; }
.b-sekolah { background:#d1fae5; color:#065f46; }
.b-instansi { background:#fef3c7; color:#92400e; }

/* TTD SECTION */
.ttd-section { display:table; width:100%; margin-top:28px; }
.ttd-left { display:table-cell; width:50%; vertical-align:top; }
.ttd-right { display:table-cell; width:50%; text-align:center; vertical-align:top; }
.ttd-box { display:inline-block; text-align:center; }
.ttd-kota-tgl { font-size:8px; margin-bottom:4px; }
.ttd-jabatan { font-size:8px; font-weight:700; }
.ttd-space { height:48px; }
.ttd-nama { font-size:9px; font-weight:900; border-top:1.5px solid #1e293b; padding-top:3px; min-width:160px; display:inline-block; text-align:center; }
.ttd-nip { font-size:7.5px; color:#64748b; }

/* CATATAN */
.catatan-box { background:#fffbeb; border:1px solid #fbbf24; border-radius:6px; padding:8px 10px; margin-bottom:12px; font-size:8px; color:#92400e; }

/* PAGE FOOTER */
.page-footer { border-top:1px solid #e2e8f0; padding-top:8px; text-align:center; font-size:7.5px; color:#94a3b8; margin-top:8px; }
</style>
</head>
<body>
<div class="page">

    {{-- KOP SURAT --}}
    <div class="kop">
        <div class="kop-left"><div class="kop-logo">⚡</div></div>
        <div class="kop-center">
            <div class="kop-title">Museum Listrik dan Energi Baru</div>
            <div class="kop-subtitle">Taman Mini Indonesia Indah (TMII), Jakarta Timur</div>
            <div class="kop-address">Telp: (021) 8779-3000 | Email: info@mleb.tmii.co.id</div>
        </div>
        <div class="kop-right"><div style="font-size:8px;color:#64748b">MLEB/LAP/{{ $tahun }}</div></div>
    </div>

    {{-- JUDUL --}}
    <div class="laporan-title-box">
        <div class="laporan-title">Laporan Kunjungan Museum</div>
        <div class="laporan-subtitle">Periode: {{ $bulanNama[$bulan] }} {{ $tahun }}</div>
    </div>

    {{-- STATISTIK --}}
    <div class="stat-row">
        <div class="stat-box"><div class="stat-val">{{ $stats['total'] }}</div><div class="stat-lbl">Total Reservasi</div></div>
        <div class="stat-box"><div class="stat-val">{{ $stats['selesai'] }}</div><div class="stat-lbl">Kunjungan Selesai</div></div>
        <div class="stat-box"><div class="stat-val">{{ number_format($stats['total_peserta']) }}</div><div class="stat-lbl">Total Peserta</div></div>
        <div class="stat-box"><div class="stat-val" style="font-size:10px">Rp {{ number_format($stats['pendapatan'],0,',','.') }}</div><div class="stat-lbl">Total Pendapatan</div></div>
    </div>

    {{-- TABEL --}}
    <table class="report">
        <thead>
            <tr>
                <th style="width:3%">#</th>
                <th style="width:14%">Kode Reservasi</th>
                <th style="width:16%">Nama Pemesan</th>
                <th style="width:10%" class="center">Tgl Kunjungan</th>
                <th style="width:12%">Jenis</th>
                <th style="width:9%">Sesi</th>
                <th style="width:6%" class="center">Peserta</th>
                <th style="width:11%" class="right">Total (Rp)</th>
                <th style="width:10%" class="center">Status</th>
                <th style="width:9%" class="center">Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasi as $i => $r)
            <tr>
                <td>{{ $i+1 }}</td>
                <td style="font-family:monospace;font-size:7.5px;font-weight:700;color:#0f3460">{{ $r->kode_reservasi }}</td>
                <td>{{ $r->nama_pemesan }}</td>
                <td class="text-center">{{ $r->tanggal_kunjungan->format('d/m/Y') }}</td>
                <td>
                    @php $jcls = match($r->jenis_kunjungan){'individu'=>'b-individu','keluarga'=>'b-keluarga','rombongan_sekolah'=>'b-sekolah','rombongan_instansi'=>'b-instansi',default=>''}; @endphp
                    <span class="badge {{ $jcls }}">{{ $r->label_jenis }}</span>
                </td>
                <td>{{ $r->jadwal->nama_sesi }}</td>
                <td class="text-center">{{ $r->jumlah_peserta }}</td>
                <td class="text-right" style="font-weight:700">{{ number_format($r->total_harga,0,',','.') }}</td>
                <td class="text-center">
                    @php $scls = match($r->status){'kunjungan_selesai'=>'b-selesai','pembayaran_terkonfirmasi'=>'b-konfirm','menunggu_pembayaran'=>'b-menunggu','dibatalkan'=>'b-batal',default=>''}; @endphp
                    <span class="badge {{ $scls }}">{{ $r->label_status }}</span>
                </td>
                <td class="text-center" style="font-size:7.5px">{{ $r->pembayaran?->label_metode ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="10" class="text-center" style="padding:12px;color:#94a3b8">Tidak ada data</td></tr>
            @endforelse
        </tbody>
        @if($reservasi->count())
        <tfoot>
            <tr>
                <td colspan="6" class="text-right">TOTAL</td>
                <td class="text-center">{{ $reservasi->sum('jumlah_peserta') }}</td>
                <td class="text-right">{{ number_format($reservasi->sum('total_harga'),0,',','.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- CATATAN --}}
    <div class="catatan-box">
        <strong>Keterangan:</strong> Laporan ini menampilkan data kunjungan pada periode {{ $bulanNama[$bulan] }} {{ $tahun }}.
        Pendapatan dihitung dari reservasi dengan status <em>Pembayaran Terkonfirmasi</em> dan <em>Kunjungan Selesai</em>.
    </div>

    {{-- TTD --}}
    <div class="ttd-section">
        <div class="ttd-left">
            <div style="font-size:8px;color:#64748b;line-height:1.8">
                Dokumen ini dicetak secara otomatis oleh sistem MLEB.<br>
                Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB
            </div>
        </div>
        <div class="ttd-right">
            <div class="ttd-box">
                <div class="ttd-kota-tgl">Jakarta, {{ now()->format('d ') . $bulanNama[now()->month] . ' ' . now()->year }}</div>
                <div class="ttd-jabatan">{{ $jabatan }}</div>
                <div class="ttd-space"></div>
                <div class="ttd-nama">{{ $namaManajer ?: '.................................' }}</div>
                @if($namaManajer)<div class="ttd-nip">Penandatangan</div>@endif
            </div>
        </div>
    </div>

    <div class="page-footer">
        © {{ $tahun }} Museum Listrik dan Energi Baru – TMII Jakarta | Laporan Kunjungan {{ $bulanNama[$bulan] }} {{ $tahun }}
    </div>

</div>
</body>
</html>
