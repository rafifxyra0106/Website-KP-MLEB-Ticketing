<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'DejaVu Sans',sans-serif; font-size:11px; color:#1e293b; background:#fff; }

.ticket-wrap { width:380px; margin:20px auto; border:3px dashed #0f3460; border-radius:16px; overflow:hidden; }

.ticket-header { background:linear-gradient(135deg,#16213e,#0f3460); color:white; padding:20px; text-align:center; }
.ticket-header .logo { font-size:22px; font-weight:900; letter-spacing:1px; margin-bottom:2px; }
.ticket-header .museum-name { font-size:9px; opacity:.75; margin-bottom:12px; }
.ticket-header .pemesan-name { font-size:14px; font-weight:800; margin-bottom:2px; }
.ticket-header .jenis { font-size:9px; opacity:.75; }

.ticket-body { padding:16px 20px; }

.qr-area { text-align:center; margin:12px 0; }
.qr-placeholder { display:inline-block; border:2px solid #e2e8f0; border-radius:10px; padding:14px; background:#f8fafc; }
.qr-icon { font-size:56px; line-height:1; }
.kode-tiket { font-family:monospace; font-size:8px; color:#64748b; margin-top:5px; word-break:break-all; max-width:150px; margin-left:auto; margin-right:auto; }

.divider { position:relative; height:1px; background:#e2e8f0; margin:12px 0; }
.divider::before { content:''; position:absolute; left:-3px; top:-6px; width:12px; height:12px; border-radius:50%; background:white; border:1px solid #e2e8f0; }
.divider::after { content:''; position:absolute; right:-3px; top:-6px; width:12px; height:12px; border-radius:50%; background:white; border:1px solid #e2e8f0; }

.info-table { width:100%; font-size:10px; }
.info-table td { padding:3px 0; }
.info-table .label { color:#64748b; width:40%; }
.info-table .value { font-weight:700; }

.tiket-list { margin-top:10px; font-size:9px; }
.tiket-list-title { font-weight:700; color:#64748b; text-transform:uppercase; font-size:8px; letter-spacing:.06em; margin-bottom:5px; }
.tiket-item-row { display:table; width:100%; padding:3px 0; border-bottom:1px dotted #f1f5f9; }
.tiket-item-name { display:table-cell; }
.tiket-item-sub { display:table-cell; text-align:right; font-weight:700; color:#0f3460; }

.total-row { display:table; width:100%; margin-top:8px; }
.total-label { display:table-cell; font-weight:700; font-size:10px; }
.total-amount { display:table-cell; text-align:right; font-weight:900; font-size:12px; color:#0f3460; }

.status-chip { display:inline-block; padding:4px 14px; border-radius:50px; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; }
.status-aktif { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; }
.status-used  { background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; }

.ticket-footer { background:#f8fafc; border-top:1px dashed #e2e8f0; padding:10px 20px; text-align:center; font-size:8px; color:#94a3b8; }
</style>
</head>
<body>

<div class="ticket-wrap">

    <div class="ticket-header">
        <div class="logo">⚡ MLEB</div>
        <div class="museum-name">Museum Listrik dan Energi Baru – TMII Jakarta</div>
        <div class="pemesan-name">{{ $tiket->reservasi->nama_pemesan }}</div>
        <div class="jenis">{{ $tiket->reservasi->label_jenis }}</div>
    </div>

    <div class="ticket-body">

        <div class="qr-area">
            <div class="qr-placeholder">
                <div class="qr-icon">📱</div>
                <div class="kode-tiket">{{ $tiket->kode_tiket }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <table class="info-table">
            <tr><td class="label">📅 Tanggal</td><td class="value">{{ $tiket->reservasi->tanggal_kunjungan->translatedFormat('l, d F Y') }}</td></tr>
            <tr><td class="label">⏰ Sesi</td><td class="value">{{ $tiket->reservasi->jadwal->nama_sesi }}</td></tr>
            <tr><td class="label">🕐 Jam</td><td class="value">{{ $tiket->reservasi->jadwal->jam }} WIB</td></tr>
            <tr><td class="label">👥 Peserta</td><td class="value">{{ $tiket->reservasi->jumlah_peserta }} orang</td></tr>
            <tr><td class="label">🎟 Kode Pesan</td><td class="value">{{ $tiket->reservasi->kode_reservasi }}</td></tr>
        </table>

        <div class="divider"></div>

        <div class="tiket-list">
            <div class="tiket-list-title">Tiket yang Dipesan</div>
            @foreach($tiket->reservasi->detail as $d)
            <div class="tiket-item-row">
                <div class="tiket-item-name">{{ $d->nama_item }} × {{ $d->jumlah }}</div>
                <div class="tiket-item-sub">Rp {{ number_format($d->subtotal,0,',','.') }}</div>
            </div>
            @endforeach
            <div class="total-row" style="margin-top:8px;padding-top:6px;border-top:1.5px solid #e2e8f0">
                <div class="total-label">Total</div>
                <div class="total-amount">Rp {{ number_format($tiket->reservasi->total_harga,0,',','.') }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <div style="text-align:center;margin-top:10px">
            <span class="status-chip {{ $tiket->status === 'aktif' ? 'status-aktif' : 'status-used' }}">
                {{ $tiket->status === 'aktif' ? '✓ TIKET AKTIF' : '✓ SUDAH DIGUNAKAN' }}
            </span>
        </div>

    </div>

    <div class="ticket-footer">
        Harap tiba 15 menit sebelum sesi dimulai • Tiket tidak dapat dipindahtangankan<br>
        Dicetak: {{ now()->format('d/m/Y H:i') }} WIB
    </div>

</div>

</body>
</html>
