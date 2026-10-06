<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'DejaVu Sans', sans-serif; font-size:11px; color:#1e293b; background:#fff; }

.page { padding:30px 35px; }

/* HEADER */
.header { display:table; width:100%; border-bottom:3px solid #0f3460; padding-bottom:14px; margin-bottom:18px; }
.header-left { display:table-cell; vertical-align:middle; width:60%; }
.header-right { display:table-cell; vertical-align:middle; text-align:right; width:40%; }
.logo-box { display:inline-block; background:#0f3460; color:#f5a623; padding:6px 14px; border-radius:6px; font-size:16px; font-weight:900; letter-spacing:1px; margin-bottom:4px; }
.company-name { font-size:13px; font-weight:700; color:#0f3460; }
.company-sub { font-size:9px; color:#64748b; }
.invoice-title { font-size:22px; font-weight:900; color:#0f3460; }
.invoice-no { font-size:11px; color:#64748b; }

/* STATUS BANNER */
.status-banner { text-align:center; padding:7px; margin-bottom:18px; border-radius:6px; font-weight:700; font-size:11px; letter-spacing:.5px; }
.status-menunggu { background:#fef3c7; color:#92400e; border:1px solid #fbbf24; }
.status-confirmed { background:#d1fae5; color:#065f46; border:1px solid #34d399; }

/* INFO GRID */
.info-grid { display:table; width:100%; margin-bottom:16px; }
.info-col { display:table-cell; width:48%; vertical-align:top; }
.info-col-sep { display:table-cell; width:4%; }
.info-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px 14px; }
.info-box-title { font-size:9px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.08em; margin-bottom:8px; border-bottom:1px solid #e2e8f0; padding-bottom:5px; }
.info-row { display:table; width:100%; margin-bottom:4px; }
.info-label { display:table-cell; color:#64748b; width:45%; font-size:10px; }
.info-value { display:table-cell; font-weight:600; font-size:10px; }

/* TABLE */
.table-title { font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.08em; margin-bottom:6px; }
table.items { width:100%; border-collapse:collapse; margin-bottom:16px; }
table.items thead th { background:#0f3460; color:white; padding:7px 10px; font-size:10px; font-weight:700; }
table.items tbody td { padding:7px 10px; font-size:10px; border-bottom:1px solid #f1f5f9; }
table.items tbody tr:last-child td { border-bottom:none; }
table.items tfoot td { background:#f8fafc; padding:7px 10px; font-size:10px; font-weight:700; border-top:2px solid #0f3460; }

/* TOTAL BOX */
.total-box { background:#0f3460; color:white; border-radius:8px; padding:12px 16px; margin-bottom:16px; text-align:right; }
.total-label { font-size:10px; opacity:.8; }
.total-amount { font-size:18px; font-weight:900; color:#f5a623; }

/* PAYMENT INFO */
.payment-box { border:1.5px solid #e2e8f0; border-radius:8px; padding:12px 14px; margin-bottom:16px; }
.payment-title { font-size:9px; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:8px; }

/* KEBUTUHAN KHUSUS */
.kebutuhan-box { background:#fffbeb; border:1px solid #fbbf24; border-radius:8px; padding:10px 14px; margin-bottom:16px; font-size:10px; }

/* FOOTER */
.footer { border-top:1px solid #e2e8f0; padding-top:12px; text-align:center; font-size:9px; color:#94a3b8; }
.footer strong { color:#0f3460; }

.text-right { text-align:right; }
.text-center { text-align:center; }
.badge { display:inline-block; padding:2px 8px; border-radius:50px; font-size:9px; font-weight:700; }
.badge-satuan { background:#e0e7ff; color:#3730a3; }
.badge-bundling { background:#fef3c7; color:#92400e; }
</style>
</head>
<body>
<div class="page">

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <div class="logo-box">⚡ MLEB</div>
            <div class="company-name" style="margin-top:4px">Museum Listrik dan Energi Baru</div>
            <div class="company-sub">Taman Mini Indonesia Indah, Jakarta Timur | (021) 8779-3000</div>
        </div>
        <div class="header-right">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-no">{{ $reservasi->kode_reservasi }}</div>
            <div style="font-size:9px;color:#64748b;margin-top:3px">Dibuat: {{ $reservasi->created_at->format('d/m/Y H:i') }} WIB</div>
        </div>
    </div>

    {{-- STATUS --}}
    @php
        $isPaid = in_array($reservasi->status, ['pembayaran_terkonfirmasi','kunjungan_selesai']);
    @endphp
    <div class="status-banner {{ $isPaid ? 'status-confirmed' : 'status-menunggu' }}">
        {{ $isPaid ? '✓ PEMBAYARAN DIKONFIRMASI' : '⏳ MENUNGGU PEMBAYARAN' }}
        @if($reservasi->pembayaran?->dikonfirmasi_at)
         — Dikonfirmasi: {{ $reservasi->pembayaran->dikonfirmasi_at->format('d/m/Y H:i') }} WIB
        @endif
    </div>

    {{-- INFO GRID --}}
    <div class="info-grid">
        <div class="info-col">
            <div class="info-box">
                <div class="info-box-title">Data Pemesan</div>
                <div class="info-row"><div class="info-label">Nama</div><div class="info-value">{{ $reservasi->nama_pemesan }}</div></div>
                <div class="info-row"><div class="info-label">Email</div><div class="info-value">{{ $reservasi->email_pemesan }}</div></div>
                <div class="info-row"><div class="info-label">WhatsApp</div><div class="info-value">{{ $reservasi->phone_pemesan }}</div></div>
                <div class="info-row"><div class="info-label">Jenis Kunjungan</div><div class="info-value">{{ $reservasi->label_jenis }}</div></div>
                @if($reservasi->nama_sekolah)
                <div class="info-row"><div class="info-label">Sekolah</div><div class="info-value">{{ $reservasi->nama_sekolah }}</div></div>
                @endif
                @if($reservasi->nama_instansi)
                <div class="info-row"><div class="info-label">Instansi</div><div class="info-value">{{ $reservasi->nama_instansi }}</div></div>
                @endif
                <div class="info-row"><div class="info-label">Jumlah Peserta</div><div class="info-value">{{ $reservasi->jumlah_peserta }} orang</div></div>
            </div>
        </div>
        <div class="info-col-sep"></div>
        <div class="info-col">
            <div class="info-box">
                <div class="info-box-title">Detail Kunjungan</div>
                <div class="info-row"><div class="info-label">Tanggal</div><div class="info-value">{{ $reservasi->tanggal_kunjungan->translatedFormat('l, d F Y') }}</div></div>
                <div class="info-row"><div class="info-label">Sesi</div><div class="info-value">{{ $reservasi->jadwal->nama_sesi }}</div></div>
                <div class="info-row"><div class="info-label">Jam</div><div class="info-value">{{ $reservasi->jadwal->jam }} WIB</div></div>
                <div class="info-row"><div class="info-label">Tipe Hari</div><div class="info-value">{{ ucfirst($reservasi->tipe_hari) }}</div></div>
                @if($reservasi->pembayaran)
                <div class="info-row"><div class="info-label">Metode Bayar</div><div class="info-value">{{ $reservasi->pembayaran->label_metode }}</div></div>
                @if($reservasi->pembayaran->nomor_va)
                <div class="info-row"><div class="info-label">Nomor VA</div><div class="info-value" style="font-family:monospace;font-weight:800">{{ $reservasi->pembayaran->nomor_va }}</div></div>
                @endif
                @endif
            </div>
        </div>
    </div>

    {{-- TIKET TABLE --}}
    <div class="table-title">Rincian Tiket yang Dipesan</div>
    <table class="items">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Tiket / Paket</th>
                <th class="text-center">Tipe</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservasi->detail as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $d->nama_item }}</td>
                <td class="text-center"><span class="badge {{ $d->tipe_item === 'satuan' ? 'badge-satuan' : 'badge-bundling' }}">{{ ucfirst($d->tipe_item) }}</span></td>
                <td class="text-center">{{ $d->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
                <td class="text-right" style="font-weight:700">Rp {{ number_format($d->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right" style="font-size:11px">TOTAL PEMBAYARAN</td>
                <td class="text-right" style="font-size:12px;color:#0f3460">Rp {{ number_format($reservasi->total_harga,0,',','.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- KEBUTUHAN KHUSUS --}}
    @if($reservasi->butuh_kursi_roda || $reservasi->butuh_pemandu || $reservasi->ada_balita || $reservasi->catatan_khusus)
    <div class="kebutuhan-box">
        <div style="font-weight:700;margin-bottom:5px;color:#92400e">⚙ Kebutuhan Khusus:</div>
        @if($reservasi->butuh_kursi_roda)<div>• Kursi roda: {{ $reservasi->jumlah_kursi_roda }} unit</div>@endif
        @if($reservasi->butuh_pemandu)<div>• Pemandu wisata (Bahasa {{ ucfirst($reservasi->bahasa_pemandu) }})</div>@endif
        @if($reservasi->ada_balita)<div>• Membawa balita: {{ $reservasi->jumlah_balita }} orang</div>@endif
        @if($reservasi->catatan_khusus)<div>• Catatan: {{ $reservasi->catatan_khusus }}</div>@endif
    </div>
    @endif

    {{-- CATATAN --}}
    <div style="background:#f0f7ff;border:1px solid #bfdbfe;border-radius:8px;padding:10px 14px;margin-bottom:16px;font-size:9px;color:#1e40af;">
        <strong>Catatan Penting:</strong><br>
        1. Invoice ini merupakan bukti pemesanan resmi dari Museum Listrik dan Energi Baru (MLEB).<br>
        2. Tunjukkan tiket digital (QR Code) kepada petugas saat tiba di museum.<br>
        3. Harap tiba 15 menit sebelum sesi dimulai.<br>
        4. Untuk informasi lebih lanjut: (021) 8779-3000 atau info@mleb.tmii.co.id
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <strong>Museum Listrik dan Energi Baru (MLEB)</strong> — Taman Mini Indonesia Indah, Jakarta Timur<br>
        Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB | {{ $reservasi->kode_reservasi }}
    </div>

</div>
</body>
</html>
