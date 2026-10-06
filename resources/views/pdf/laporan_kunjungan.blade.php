<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #222; }
    .header { text-align: center; border-bottom: 3px solid #ffc107; padding-bottom: 10px; margin-bottom: 15px; }
    .header h2 { margin: 0; color: #0d3b66; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    table td, table th { padding: 5px 7px; border: 1px solid #999; font-size: 10px; }
    th { background: #0d3b66; color: white; }
    .ringkasan td { border: none; padding: 3px 8px; }
    .ttd-box { width: 220px; text-align: center; margin-left: auto; margin-top: 40px; }
    .ttd-img { height: 60px; margin: 5px 0; }
</style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KUNJUNGAN MUSEUM</h2>
        <p>Museum Listrik dan Energi Baru (MLEB)</p>
        <p>Periode: {{ \Carbon\Carbon::parse($dariTanggal)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($sampaiTanggal)->translatedFormat('d F Y') }}</p>
    </div>

    <table class="ringkasan">
        <tr>
            <td><strong>Total Reservasi</strong>: {{ $reservasi->count() }}</td>
            <td><strong>Total Pengunjung</strong>: {{ $totalPengunjung }} orang</td>
            <td><strong>Total Tiket Terjual</strong>: {{ $totalTiket }}</td>
            <td><strong>Total Pendapatan</strong>: Rp {{ number_format($totalPendapatan,0,',','.') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th><th>Kode Reservasi</th><th>Tanggal</th><th>Jam</th><th>Nama Penanggung Jawab</th>
                <th>Jenis Kunjungan</th><th>Jml Peserta</th><th>Jml Tiket</th><th>Total Harga</th><th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasi as $i => $r)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $r->kode_reservasi }}</td>
                <td>{{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('d-m-Y') }}</td>
                <td>{{ substr($r->jam_kunjungan,0,5) }}</td>
                <td>{{ $r->penanggung_jawab }}</td>
                <td>{{ $r->jenis_kunjungan_label }}</td>
                <td>{{ $r->jumlah_peserta }}</td>
                <td>{{ $r->jumlah_tiket }}</td>
                <td>Rp {{ number_format($r->total_harga,0,',','.') }}</td>
                <td>{{ $r->pembayaran->status_label ?? 'Belum Bayar' }}</td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align:center;">Tidak ada data pada periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p><strong>Rekap Berdasarkan Jenis Kunjungan:</strong></p>
    <table style="width:50%;">
        <thead><tr><th>Jenis Kunjungan</th><th>Jumlah Peserta</th></tr></thead>
        <tbody>
        @foreach($rekapJenis as $jenis => $jumlah)
            <tr><td>{{ \App\Models\ReservasiKunjungan::labelJenisKunjungan()[$jenis] ?? $jenis }}</td><td>{{ $jumlah }}</td></tr>
        @endforeach
        </tbody>
    </table>

    <table style="border:none; margin-top: 30px;">
        <tr style="border:none;">
            <td style="border:none; width: 60%;"></td>
            <td style="border:none; text-align:center;">
                Cikarang, {{ $tanggalCetak }}<br>
                Mengetahui,<br>
                {{ $pengaturan->jabatan }}<br><br>
                @if($pengaturan->tanda_tangan)
                    <img src="{{ public_path('images/ttd/'.$pengaturan->tanda_tangan) }}" class="ttd-img"><br>
                @else
                    <br><br><br>
                @endif
                <strong>{{ $pengaturan->nama_manajer ?: '(...........................)' }}</strong>
            </td>
        </tr>
    </table>
</body>
</html>
