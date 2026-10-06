@extends('layouts.app')
@section('title','Jadwal Kunjungan')

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-calendar3 me-2"></i>Jadwal Kunjungan</h1>
        <p class="mb-0">Pilih tanggal dan cek ketersediaan sesi kunjungan secara langsung</p>
    </div>
</div>

<section class="py-4">
<div class="container">
<div class="row g-4">

    {{-- PILIH TANGGAL --}}
    <div class="col-lg-4">
        <div class="card-mleb card sticky-lg-top sticky-side-card">
            <div class="card-header fw-bold"><i class="bi bi-calendar-date me-2 text-primary"></i>Pilih Tanggal</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Tanggal Kunjungan</label>
                    <input type="date" id="tanggalCek" class="form-control"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>

                <div id="tipeHariInfo" class="mb-3" style="display:none">
                    <span id="tipeHariBadge" class="badge fs-6 px-3 py-2 w-100 text-center"></span>
                    <div class="text-muted small mt-1 text-center" id="tipeHariNote"></div>
                </div>

                <div class="alert alert-info py-2 small">
                    <i class="bi bi-info-circle me-1"></i>
                    Harga <strong>weekday</strong> (Senin–Jumat) lebih murah dari <strong>weekend</strong> (Sabtu–Minggu).
                </div>

                <a href="{{ route('reservasi.create') }}" class="btn btn-mleb w-100">
                    <i class="bi bi-ticket-perforated me-2"></i>Pesan Tiket Sekarang
                </a>
            </div>
        </div>
    </div>

    {{-- SESI & HARGA --}}
    <div class="col-lg-8">

        {{-- SESI KUNJUNGAN --}}
        <div class="card-mleb card mb-4">
            <div class="card-header fw-bold">
                <i class="bi bi-clock me-2 text-primary"></i>Sesi Kunjungan
                <span class="ms-auto text-muted small fw-normal" id="tanggalLabel">–</span>
            </div>
            <div class="card-body p-0" id="sesiContainer">
                <div class="text-center py-5 text-muted">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                    Memuat jadwal...
                </div>
            </div>
        </div>

        {{-- HARGA TIKET --}}
        <div class="card-mleb card mb-4">
            <div class="card-header fw-bold">
                <i class="bi bi-ticket-perforated me-2 text-primary"></i>Daftar Harga Tiket
                <span class="ms-2 small fw-normal" id="hargaLabel" style="color:var(--mleb-yellow)"></span>
            </div>
            <div class="card-body">
                <div class="row g-3" id="hargaTiketContainer">
                    @foreach($jadwal as $j)
                    {{-- placeholder saat JS belum load --}}
                    @endforeach
                    <div class="col-12 text-center text-muted small py-2">Pilih tanggal untuk melihat harga</div>
                </div>

                <hr>

                {{-- BUNDLING --}}
                <div class="fw-bold mb-3 small text-muted text-uppercase" style="letter-spacing:.06em">
                    <i class="bi bi-collection me-2"></i>Paket Bundling
                </div>
                <div class="row g-2" id="hargaBundlingContainer">
                    <div class="col-12 text-center text-muted small py-2">Pilih tanggal untuk melihat harga</div>
                </div>
            </div>
        </div>

        {{-- INFO PENTING --}}
        <div class="card-mleb card">
            <div class="card-header fw-bold"><i class="bi bi-exclamation-circle me-2 text-warning"></i>Informasi Penting</div>
            <div class="card-body">
                <ul class="small text-muted mb-0" style="line-height:2.2">
                    <li>Museum buka <strong>Selasa – Minggu</strong>, pukul <strong>09.00 – 17.00 WIB</strong></li>
                    <li>Harap tiba <strong>minimal 15 menit</strong> sebelum sesi dimulai</li>
                    <li>Reservasi wajib dilakukan <strong>minimal 1 hari sebelum</strong> kunjungan</li>
                    <li>Harga <strong>weekend</strong> (Sabtu–Minggu) lebih tinggi dari hari kerja</li>
                    <li>Tiket digital akan dikirim setelah pembayaran dikonfirmasi</li>
                    <li>Rombongan minimal <strong>10 peserta</strong></li>
                    <li>Pembayaran via <strong>Virtual Account</strong> (BCA/Mandiri/BNI/BRI) atau <strong>QRIS</strong></li>
                </ul>
            </div>
        </div>

    </div>
</div>
</div>
</section>
@endsection

@push('scripts')
<script>
var allJadwal = @json($jadwal);

function loadJadwal() {
    var tgl   = document.getElementById('tanggalCek').value;
    var label = document.getElementById('tanggalLabel');
    var badge = document.getElementById('tipeHariBadge');
    var note  = document.getElementById('tipeHariNote');
    var info  = document.getElementById('tipeHariInfo');

    if (!tgl) return;

    // Format tanggal untuk label
    var d = new Date(tgl);
    var hariNama = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var bulanNama = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    label.textContent = hariNama[d.getDay()] + ', ' + d.getDate() + ' ' + bulanNama[d.getMonth()] + ' ' + d.getFullYear();

    // Fetch kuota + tipe hari
    fetch('/api/kuota-sesi?tanggal=' + tgl, { headers: {'X-Requested-With':'XMLHttpRequest'} })
        .then(r => r.json())
        .then(function(data) {
            var tipeHari = data.tipe_hari;

            // Update badge
            info.style.display = '';
            if (tipeHari === 'weekend') {
                badge.className = 'badge fs-6 px-3 py-2 w-100 text-center bg-warning text-dark';
                badge.textContent = '🌟 Akhir Pekan — Harga Weekend Berlaku';
                note.textContent  = 'Sabtu & Minggu menggunakan tarif weekend';
                document.getElementById('hargaLabel').textContent = '(Harga Weekend)';
            } else {
                badge.className = 'badge fs-6 px-3 py-2 w-100 text-center bg-info text-dark';
                badge.textContent = '📅 Hari Kerja — Harga Weekday Berlaku';
                note.textContent  = 'Senin–Jumat menggunakan tarif weekday';
                document.getElementById('hargaLabel').textContent = '(Harga Weekday)';
            }

            // Render sesi
            renderSesi(data.sesi, tgl);

            // Fetch harga tiket
            fetch('/api/harga-tiket?tipe_hari=' + tipeHari, { headers: {'X-Requested-With':'XMLHttpRequest'} })
                .then(r => r.json())
                .then(function(hargaData) {
                    renderHargaTiket(hargaData.tiket);
                    renderHargaBundling(hargaData.bundling);
                });
        });
}

function renderSesi(sesi, tgl) {
    var container = document.getElementById('sesiContainer');
    if (!sesi.length) {
        container.innerHTML = '<div class="text-center py-4 text-muted">Tidak ada sesi tersedia</div>';
        return;
    }
    var html = '<div class="table-responsive"><table class="table mb-0"><thead><tr><th>Sesi</th><th>Jam</th><th class="text-center">Sisa Kuota</th><th>Status</th><th></th></tr></thead><tbody>';
    sesi.forEach(function(s) {
        var statusCls = s.sisa_kuota === 0 ? 'danger' : (s.sisa_kuota <= 10 ? 'warning' : 'success');
        var statusTxt = s.sisa_kuota === 0 ? 'Penuh' : ('Sisa ' + s.sisa_kuota + ' orang');
        html += '<tr>';
        html += '<td class="fw-semibold">' + s.nama_sesi + '</td>';
        html += '<td class="small text-muted"><i class="bi bi-clock me-1"></i>' + s.jam + ' WIB</td>';
        html += '<td class="text-center"><span class="badge bg-' + statusCls + (statusCls === 'warning' ? ' text-dark' : '') + '">' + statusTxt + '</span></td>';
        html += '<td>' + (s.sisa_kuota > 0 ? '<span class="badge bg-success">Tersedia</span>' : '<span class="badge bg-secondary">Tidak Tersedia</span>') + '</td>';
        html += '<td>' + (s.sisa_kuota > 0 ? '<a href="/reservasi?jadwal_id=' + s.id + '" class="btn btn-sm btn-mleb">Pesan</a>' : '<button class="btn btn-sm btn-secondary" disabled>Penuh</button>') + '</td>';
        html += '</tr>';
    });
    html += '</tbody></table></div>';
    container.innerHTML = html;
}

function renderHargaTiket(tiket) {
    var container = document.getElementById('hargaTiketContainer');
    if (!tiket.length) { container.innerHTML = '<div class="col-12 text-muted small">Tidak ada data</div>'; return; }
    var html = '';
    tiket.forEach(function(t) {
        html += '<div class="col-sm-6 col-lg-4">';
        html += '<div class="d-flex align-items-center gap-2 p-2 border rounded-2">';
        html += '<span style="font-size:1.4rem">' + (t.ikon || '🎫') + '</span>';
        html += '<div><div class="fw-semibold small">' + t.nama + '</div>';
        html += '<div style="color:var(--mleb-primary);font-weight:700;font-size:.9rem">Rp ' + parseInt(t.harga).toLocaleString('id-ID') + '<span class="text-muted fw-normal">/orang</span></div></div>';
        html += '</div></div>';
    });
    container.innerHTML = html;
}

function renderHargaBundling(bundling) {
    var container = document.getElementById('hargaBundlingContainer');
    if (!bundling.length) { container.innerHTML = '<div class="col-12 text-muted small">Tidak ada data</div>'; return; }
    var html = '';
    bundling.forEach(function(b) {
        html += '<div class="col-sm-6">';
        html += '<div class="p-2 border rounded-2 position-relative">';
        if (b.badge_label) html += '<span class="badge bg-warning text-dark" style="position:absolute;top:6px;right:6px;font-size:.65rem">' + b.badge_label + '</span>';
        html += '<div class="fw-semibold small mb-1">🎫 ' + b.nama + '</div>';
        html += '<div class="text-muted" style="font-size:.72rem">' + b.isi + '</div>';
        html += '<div style="color:var(--mleb-primary);font-weight:700;margin-top:.25rem">Rp ' + parseInt(b.harga).toLocaleString('id-ID') + '<span class="text-muted fw-normal text-sm">/paket</span></div>';
        html += '</div></div>';
    });
    container.innerHTML = html;
}

document.getElementById('tanggalCek').addEventListener('change', loadJadwal);
loadJadwal(); // load on page ready
</script>
@endpush
