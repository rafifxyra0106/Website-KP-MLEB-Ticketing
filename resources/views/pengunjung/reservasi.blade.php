@extends('layouts.app')
@section('title','Pesan Tiket')

@section('content')
<div class="page-header">
    <div class="container">
        <h1><i class="bi bi-ticket-perforated me-2"></i>Pesan Tiket Kunjungan</h1>
        <p class="mb-0">Isi formulir di bawah untuk memesan tiket kunjungan Museum Listrik dan Energi Baru</p>
    </div>
</div>

<section class="py-4">
<div class="container">

{{-- STEP INDICATOR --}}
<div class="d-flex align-items-center justify-content-center gap-2 mb-4 flex-wrap">
    @foreach([['1','Jadwal & Tiket'],['2','Data Pemesan'],['3','Kebutuhan Khusus']] as $i => $step)
    <div class="d-flex align-items-center gap-2">
        <div class="d-flex align-items-center gap-2" id="step-indicator-{{ $step[0] }}">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                style="width:32px;height:32px;background:var(--mleb-primary);color:white;font-size:.85rem">{{ $step[0] }}</div>
            <span class="fw-semibold small d-none d-md-inline">{{ $step[1] }}</span>
        </div>
        @if($i < 2)<div style="width:40px;height:2px;background:#e2e8f0"></div>@endif
    </div>
    @endforeach
</div>

<form action="{{ route('reservasi.store') }}" method="POST" id="reservasiForm">
@csrf

{{-- ═══ STEP 1: JADWAL & TIKET ═══ --}}
<div id="formStep1">
<div class="row g-4">

    {{-- PILIH JADWAL --}}
    <div class="col-12">
        <div class="card-mleb card">
            <div class="card-header">
                <i class="bi bi-calendar3 me-2 text-primary"></i>
                <span>Langkah 1 — Pilih Jadwal Kunjungan</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kunjungan" id="tanggalInput"
                            class="form-control @error('tanggal_kunjungan') is-invalid @enderror"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            value="{{ old('tanggal_kunjungan') }}" required>
                        @error('tanggal_kunjungan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="tipeHariInfo" class="mt-2" style="display:none">
                            <span id="tipeHariBadge" class="badge"></span>
                            <small class="text-muted ms-1" id="tipeHariNote"></small>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label">Sesi Kunjungan <span class="text-danger">*</span></label>
                        <div id="sesiContainer" class="row g-2">
                            <div class="col-12 text-muted small"><i class="bi bi-arrow-left me-1"></i>Pilih tanggal terlebih dahulu</div>
                        </div>
                        <input type="hidden" name="jadwal_id" id="jadwalIdInput" value="{{ old('jadwal_id') }}" required>
                        @error('jadwal_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PILIH TIKET --}}
    <div class="col-12">
        <div class="card-mleb card">
            <div class="card-header">
                <i class="bi bi-ticket-perforated me-2 text-primary"></i>
                <span>Langkah 2 — Pilih Tiket</span>
                <span class="ms-auto text-muted small" id="tipeHariLabel"></span>
            </div>
            <div class="card-body">

                {{-- TIKET SATUAN --}}
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-ticket me-2"></i>Tiket Satuan
                        <small class="fw-normal text-muted ms-2">Pilih satu atau lebih</small>
                    </h6>
                    <div class="row g-2" id="tiketSatuanContainer">
                        @foreach($tiket as $t)
                        <div class="col-sm-6 col-lg-4">
                            <div class="tiket-item tiket-qty-row" data-harga="{{ $t->harga_weekday }}"
                                data-harga-weekday="{{ $t->harga_weekday }}" data-harga-weekend="{{ $t->harga_weekend }}"
                                data-id="{{ $t->id }}" data-tipe="satuan">
                                <div class="d-flex align-items-start gap-2">
                                    <input type="checkbox" class="form-check-input flex-shrink-0 mt-1" data-tiket-check
                                        id="tiket_{{ $t->id }}" style="width:18px;height:18px">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">{{ $t->ikon }} {{ $t->nama }}</div>
                                        <div class="text-muted" style="font-size:.75rem">{{ Str::limit($t->deskripsi,60) }}</div>
                                        <div class="mt-1">
                                            <span class="harga-badge tiket-harga" style="font-size:.75rem">
                                                Rp {{ number_format($t->harga_weekday,0,',','.') }}/orang
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex align-items-center justify-content-between" style="display:none!important" id="qtyRow_{{ $t->id }}">
                                    <small class="text-muted">Jumlah:</small>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeQty('qty_{{ $t->id }}',-1)">−</button>
                                        <input type="number" id="qty_{{ $t->id }}" data-qty min="1" value="1"
                                            class="form-control form-control-sm text-center" style="width:55px">
                                        <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeQty('qty_{{ $t->id }}',1)">+</button>
                                    </div>
                                </div>
                                <div class="mt-1 text-end">
                                    <small class="fw-bold" style="color:var(--mleb-primary)" data-subtotal>Rp 0</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <hr>

                {{-- BUNDLING --}}
                <div>
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-collection me-2"></i>Paket Bundling
                        <small class="fw-normal text-muted ms-2">Lebih hemat dari tiket satuan</small>
                    </h6>
                    <div class="row g-2" id="bundlingContainer">
                        @foreach($bundling as $b)
                        <div class="col-sm-6 col-lg-4">
                            <div class="tiket-item tiket-qty-row" data-harga="{{ $b->harga_weekday }}"
                                data-harga-weekday="{{ $b->harga_weekday }}" data-harga-weekend="{{ $b->harga_weekend }}"
                                data-id="{{ $b->id }}" data-tipe="bundling">
                                @if($b->badge_label)
                                <span class="badge bg-warning text-dark mb-1" style="font-size:.7rem">{{ $b->badge_label }}</span>
                                @endif
                                <div class="d-flex align-items-start gap-2">
                                    <input type="checkbox" class="form-check-input flex-shrink-0 mt-1" data-tiket-check
                                        id="bundling_{{ $b->id }}" style="width:18px;height:18px">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">🎫 {{ $b->nama }}</div>
                                        <div class="text-muted mt-1" style="font-size:.72rem">
                                            @foreach($b->jenisTiket as $jt)
                                            <span>{{ $jt->ikon }} {{ $jt->nama }}</span>@if(!$loop->last), @endif
                                            @endforeach
                                        </div>
                                        <div class="mt-1">
                                            <span class="harga-badge tiket-harga" style="font-size:.75rem">
                                                Rp {{ number_format($b->harga_weekday,0,',','.') }}/paket
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex align-items-center justify-content-between">
                                    <small class="text-muted">Jumlah paket:</small>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeQty('bqty_{{ $b->id }}',-1)">−</button>
                                        <input type="number" id="bqty_{{ $b->id }}" data-qty min="1" value="1"
                                            class="form-control form-control-sm text-center" style="width:55px">
                                        <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="changeQty('bqty_{{ $b->id }}',1)">+</button>
                                    </div>
                                </div>
                                <div class="mt-1 text-end">
                                    <small class="fw-bold" style="color:var(--mleb-primary)" data-subtotal>Rp 0</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- TOTAL --}}
                <div class="mt-4 p-3 rounded-3" style="background:var(--mleb-primary)">
                    <div class="d-flex justify-content-between align-items-center text-white">
                        <span class="fw-semibold">Estimasi Total Pembayaran:</span>
                        <span class="fw-bold fs-4" id="grand-total">Rp 0</span>
                    </div>
                    <div class="text-white opacity-65 small mt-1">
                        <i class="bi bi-info-circle me-1"></i>Total dihitung berdasarkan tiket yang dipilih × jumlah
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 text-end">
        <button type="button" class="btn btn-mleb btn-lg px-5" onclick="goStep(2)">
            Lanjutkan <i class="bi bi-arrow-right ms-2"></i>
        </button>
    </div>
</div>
</div>

{{-- ═══ STEP 2: DATA PEMESAN ═══ --}}
<div id="formStep2" style="display:none">
<div class="row g-4">
    <div class="col-12">
        <div class="card-mleb card">
            <div class="card-header">
                <i class="bi bi-person me-2 text-primary"></i>
                <span>Langkah 3 — Jenis & Data Kunjungan</span>
            </div>
            <div class="card-body">

                {{-- JENIS KUNJUNGAN --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Jenis Kunjungan <span class="text-danger">*</span></label>
                    <p class="text-muted small mb-3">Pilih jenis kunjungan sesuai dengan kebutuhan Anda</p>
                    <div class="row g-2">
                        @foreach([
                            ['individu','bi-person','Individu','Kunjungan 1 orang. Tidak ada syarat khusus.','1-9 orang'],
                            ['keluarga','bi-people','Keluarga','Kunjungan bersama keluarga/pasangan. Tidak ada syarat khusus.','1-20 orang'],
                            ['rombongan_sekolah','bi-mortarboard','Rombongan Sekolah','Kunjungan rombongan siswa dari sekolah/lembaga pendidikan. Wajib ada guru pendamping.','Min. 10 orang'],
                            ['rombongan_instansi','bi-building','Rombongan Instansi','Kunjungan rombongan dari perusahaan atau instansi pemerintah/swasta.','Min. 10 orang'],
                        ] as $j)
                        <div class="col-sm-6">
                            <label class="d-block" style="cursor:pointer">
                                <input type="radio" name="jenis_kunjungan" value="{{ $j[0] }}"
                                    class="d-none jenis-radio" {{ old('jenis_kunjungan') == $j[0] ? 'checked' : '' }}>
                                <div class="payment-box jenis-box {{ old('jenis_kunjungan') == $j[0] ? 'selected' : '' }}">
                                    <div class="d-flex gap-3 align-items-start">
                                        <i class="bi {{ $j[1] }} fs-3 flex-shrink-0" style="color:var(--mleb-primary)"></i>
                                        <div>
                                            <div class="fw-bold small">{{ $j[2] }}</div>
                                            <div class="text-muted" style="font-size:.75rem">{{ $j[3] }}</div>
                                            <span class="badge bg-light text-secondary border mt-1" style="font-size:.7rem">{{ $j[4] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('jenis_kunjungan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                {{-- DATA ROMBONGAN (conditional) --}}
                <div id="dataRombonganSekolah" style="display:none">
                    <div class="alert alert-info small"><i class="bi bi-info-circle me-2"></i>Lengkapi data rombongan sekolah berikut</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_sekolah" class="form-control" placeholder="SMA Negeri 1 Jakarta" value="{{ old('nama_sekolah') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Guru Pendamping <span class="text-danger">*</span></label>
                            <input type="text" name="nama_guru_pendamping" class="form-control" placeholder="Nama guru pendamping" value="{{ old('nama_guru_pendamping') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelas / Tingkat</label>
                            <input type="text" name="kelas_rombongan" class="form-control" placeholder="Contoh: X IPA 1 – XII IPS 3" value="{{ old('kelas_rombongan') }}">
                        </div>
                    </div>
                </div>

                <div id="dataRombonganInstansi" style="display:none">
                    <div class="alert alert-info small"><i class="bi bi-info-circle me-2"></i>Lengkapi data instansi berikut</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Instansi / Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_instansi" class="form-control" placeholder="PT Contoh Indonesia" value="{{ old('nama_instansi') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama PIC / Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pic_instansi" class="form-control" placeholder="Nama person in charge" value="{{ old('nama_pic_instansi') }}">
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- DATA PEMESAN --}}
                <div class="row g-3">
                    <div class="col-12"><h6 class="fw-bold">Data Pemesan</h6></div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap Pemesan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemesan" class="form-control @error('nama_pemesan') is-invalid @enderror"
                            value="{{ old('nama_pemesan', auth()->user()->name) }}" required>
                        @error('nama_pemesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Pemesan <span class="text-danger">*</span></label>
                        <input type="email" name="email_pemesan" class="form-control @error('email_pemesan') is-invalid @enderror"
                            value="{{ old('email_pemesan', auth()->user()->email) }}" required>
                        @error('email_pemesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. WhatsApp Aktif <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">+62</span>
                            <input type="text" name="phone_pemesan" class="form-control @error('phone_pemesan') is-invalid @enderror"
                                placeholder="8xxxxxxxxxx" value="{{ old('phone_pemesan', auth()->user()->phone) }}" required>
                        </div>
                        @error('phone_pemesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Peserta <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="jumlah_peserta" class="form-control @error('jumlah_peserta') is-invalid @enderror"
                                min="1" max="500" value="{{ old('jumlah_peserta', 1) }}" required>
                            <span class="input-group-text">orang</span>
                        </div>
                        <div class="form-text">Rombongan minimal 10 orang</div>
                        @error('jumlah_peserta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 d-flex justify-content-between">
        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="goStep(1)">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </button>
        <button type="button" class="btn btn-mleb btn-lg px-5" onclick="goStep(3)">
            Lanjutkan <i class="bi bi-arrow-right ms-2"></i>
        </button>
    </div>
</div>
</div>

{{-- ═══ STEP 3: KEBUTUHAN KHUSUS ═══ --}}
<div id="formStep3" style="display:none">
<div class="row g-4">
    <div class="col-12">
        <div class="card-mleb card">
            <div class="card-header">
                <i class="bi bi-heart me-2 text-primary"></i>
                <span>Langkah 4 — Kebutuhan & Catatan Khusus</span>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-4">Informasi ini membantu kami mempersiapkan kunjungan terbaik untuk Anda. Semua field bersifat opsional.</p>

                <div class="row g-4">
                    {{-- Kursi roda --}}
                    <div class="col-md-6">
                        <div class="card border h-100">
                            <div class="card-body">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="butuh_kursi_roda"
                                        id="switchKursiRoda" value="1" {{ old('butuh_kursi_roda') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="switchKursiRoda">
                                        ♿ Membutuhkan Kursi Roda
                                    </label>
                                </div>
                                <p class="text-muted small mb-2">Museum menyediakan fasilitas kursi roda gratis untuk pengunjung berkebutuhan khusus.</p>
                                <div id="kursiRodaDetail" style="display:{{ old('butuh_kursi_roda') ? 'block' : 'none' }}">
                                    <label class="form-label small">Jumlah kursi roda yang dibutuhkan:</label>
                                    <input type="number" name="jumlah_kursi_roda" class="form-control form-control-sm"
                                        min="1" max="10" value="{{ old('jumlah_kursi_roda', 1) }}" style="width:100px">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pemandu --}}
                    <div class="col-md-6">
                        <div class="card border h-100">
                            <div class="card-body">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="butuh_pemandu"
                                        id="switchPemandu" value="1" {{ old('butuh_pemandu') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="switchPemandu">
                                        🎙️ Membutuhkan Pemandu Wisata
                                    </label>
                                </div>
                                <p class="text-muted small mb-2">Pemandu akan menjelaskan koleksi dan sejarah museum secara detail. (Termasuk dalam tiket Energy Guide)</p>
                                <div id="pemanduDetail" style="display:{{ old('butuh_pemandu') ? 'block' : 'none' }}">
                                    <label class="form-label small">Bahasa pemandu:</label>
                                    <select name="bahasa_pemandu" class="form-select form-select-sm" style="width:160px">
                                        <option value="indonesia" {{ old('bahasa_pemandu') == 'indonesia' ? 'selected' : '' }}>🇮🇩 Bahasa Indonesia</option>
                                        <option value="inggris" {{ old('bahasa_pemandu') == 'inggris' ? 'selected' : '' }}>🇬🇧 English</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Balita --}}
                    <div class="col-md-6">
                        <div class="card border h-100">
                            <div class="card-body">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="ada_balita"
                                        id="switchBalita" value="1" {{ old('ada_balita') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="switchBalita">
                                        👶 Membawa Balita (0–5 tahun)
                                    </label>
                                </div>
                                <p class="text-muted small mb-2">Tersedia area khusus dan fasilitas ramah balita di museum.</p>
                                <div id="balitaDetail" style="display:{{ old('ada_balita') ? 'block' : 'none' }}">
                                    <label class="form-label small">Jumlah balita:</label>
                                    <input type="number" name="jumlah_balita" class="form-control form-control-sm"
                                        min="1" max="20" value="{{ old('jumlah_balita', 1) }}" style="width:100px">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="col-md-6">
                        <div class="card border h-100">
                            <div class="card-body">
                                <label class="form-label fw-semibold">📝 Catatan Tambahan</label>
                                <p class="text-muted small mb-2">Informasi lain yang perlu diketahui pihak museum (mis: alergi, kebutuhan diet, request khusus).</p>
                                <textarea name="catatan_khusus" class="form-control" rows="3"
                                    placeholder="Contoh: Ada anggota rombongan yang alergi debu..." maxlength="500">{{ old('catatan_khusus') }}</textarea>
                                <div class="form-text">Maksimal 500 karakter</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- HIDDEN ITEMS --}}
                <div id="hiddenItemsContainer"></div>

                {{-- RINGKASAN --}}
                <div class="mt-4 p-4 rounded-3" style="background:#f8fafc;border:1.5px solid #e2e8f0">
                    <h6 class="fw-bold mb-3"><i class="bi bi-receipt me-2"></i>Ringkasan Pemesanan</h6>
                    <div id="ringkasanContent" class="small text-muted">Lengkapi data terlebih dahulu...</div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total Pembayaran:</span>
                        <span class="fw-bold fs-5" style="color:var(--mleb-primary)" id="ringkasanTotal">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 d-flex justify-content-between">
        <button type="button" class="btn btn-outline-secondary btn-lg" onclick="goStep(2)">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </button>
        <button type="submit" class="btn btn-mleb-yellow btn-lg px-5 fw-bold" id="btnSubmit">
            <i class="bi bi-check-circle me-2"></i>Buat Pesanan
        </button>
    </div>
</div>
</div>

</form>
</div>
</section>
@endsection

@push('scripts')
<script>
var currentStep = 1;
var tipeHari = 'weekday';
var selectedItems = {};

// ── STEP NAVIGATION ─────────────────────────────────────
function goStep(step) {
    if (step === 2 && !validateStep1()) return;
    if (step === 3) {
        buildRingkasan();
        buildHiddenInputs();
    }
    document.getElementById('formStep1').style.display = step === 1 ? '' : 'none';
    document.getElementById('formStep2').style.display = step === 2 ? '' : 'none';
    document.getElementById('formStep3').style.display = step === 3 ? '' : 'none';
    currentStep = step;
    window.scrollTo({top: 0, behavior: 'smooth'});
}

function validateStep1() {
    var tanggal = document.getElementById('tanggalInput').value;
    var jadwalId = document.getElementById('jadwalIdInput').value;
    var checked = document.querySelectorAll('[data-tiket-check]:checked');

    if (!tanggal) { Swal.fire('Perhatian','Pilih tanggal kunjungan terlebih dahulu.','warning'); return false; }
    if (!jadwalId) { Swal.fire('Perhatian','Pilih sesi kunjungan terlebih dahulu.','warning'); return false; }
    if (!checked.length) { Swal.fire('Perhatian','Pilih minimal 1 tiket atau bundling.','warning'); return false; }
    return true;
}

// ── JADWAL LOAD ──────────────────────────────────────────
document.getElementById('tanggalInput').addEventListener('change', function () {
    var tgl = this.value;
    if (!tgl) return;
    fetch('/api/kuota-sesi?tanggal=' + tgl, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(r => r.json()).then(data => {
            tipeHari = data.tipe_hari;
            updateTipeHariUI();
            updateHargaByTipe();
            renderSesi(data.sesi);
        });
});

function updateTipeHariUI() {
    var badge = document.getElementById('tipeHariBadge');
    var note  = document.getElementById('tipeHariNote');
    var info  = document.getElementById('tipeHariInfo');
    var label = document.getElementById('tipeHariLabel');
    info.style.display = '';
    if (tipeHari === 'weekend') {
        badge.className = 'badge bg-warning text-dark';
        badge.textContent = '🌟 Akhir Pekan';
        note.textContent = 'Harga weekend berlaku';
        if (label) label.textContent = '(Harga Weekend)';
    } else {
        badge.className = 'badge bg-info text-dark';
        badge.textContent = '📅 Hari Kerja';
        note.textContent = 'Harga weekday berlaku';
        if (label) label.textContent = '(Harga Weekday)';
    }
}

function updateHargaByTipe() {
    document.querySelectorAll('.tiket-qty-row').forEach(function (row) {
        var harga = parseFloat(tipeHari === 'weekend' ? row.dataset.hargaWeekend : row.dataset.hargaWeekday) || 0;
        row.dataset.harga = harga;
        var hargaEl = row.querySelector('.tiket-harga');
        if (hargaEl) hargaEl.textContent = 'Rp ' + harga.toLocaleString('id-ID') + '/orang';
    });
    recalcTotal();
}

function renderSesi(sesi) {
    var container = document.getElementById('sesiContainer');
    container.innerHTML = '';
    sesi.forEach(function (s) {
        var disabled = s.sisa_kuota === 0;
        var html = '<div class="col-sm-6">';
        html += '<label class="d-block" style="cursor:' + (disabled ? 'not-allowed' : 'pointer') + '">';
        html += '<input type="radio" name="_sesi_radio" value="' + s.id + '" class="d-none sesi-radio" ' + (disabled ? 'disabled' : '') + '>';
        html += '<div class="payment-box ' + (disabled ? 'opacity-50' : '') + '">';
        html += '<div class="fw-semibold small">' + s.nama_sesi + '</div>';
        html += '<div class="text-muted" style="font-size:.75rem"><i class="bi bi-clock me-1"></i>' + s.jam + ' WIB</div>';
        html += '<div class="mt-1">';
        if (disabled) {
            html += '<span class="badge bg-danger" style="font-size:.7rem">Penuh</span>';
        } else {
            var cls = s.sisa_kuota <= 10 ? 'bg-warning text-dark' : 'bg-success';
            html += '<span class="badge ' + cls + '" style="font-size:.7rem">Sisa ' + s.sisa_kuota + ' orang</span>';
        }
        html += '</div></div></label></div>';
        container.innerHTML += html;
    });

    document.querySelectorAll('.sesi-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.getElementById('jadwalIdInput').value = this.value;
            document.querySelectorAll('.sesi-radio').forEach(function (r) {
                r.closest('label').querySelector('.payment-box').classList.remove('selected');
            });
            this.closest('label').querySelector('.payment-box').classList.add('selected');
        });
    });
}

// ── TIKET CHECKBOXES ─────────────────────────────────────
document.addEventListener('change', function (e) {
    if (e.target.matches('[data-tiket-check]')) {
        var row = e.target.closest('.tiket-qty-row');
        if (e.target.checked) {
            row.classList.add('selected');
        } else {
            row.classList.remove('selected');
        }
        recalcTotal();
    }
});

// ── JENIS KUNJUNGAN ──────────────────────────────────────
document.querySelectorAll('.jenis-radio').forEach(function (radio) {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.jenis-box').forEach(b => b.classList.remove('selected'));
        this.closest('label').querySelector('.jenis-box').classList.add('selected');
        var v = this.value;
        document.getElementById('dataRombonganSekolah').style.display = v === 'rombongan_sekolah' ? '' : 'none';
        document.getElementById('dataRombonganInstansi').style.display = v === 'rombongan_instansi' ? '' : 'none';
    });
});

// ── SWITCH TOGGLES ───────────────────────────────────────
['switchKursiRoda', 'switchPemandu', 'switchBalita'].forEach(function (id) {
    var el = document.getElementById(id);
    if (!el) return;
    var detailId = id === 'switchKursiRoda' ? 'kursiRodaDetail' : (id === 'switchPemandu' ? 'pemanduDetail' : 'balitaDetail');
    el.addEventListener('change', function () {
        document.getElementById(detailId).style.display = this.checked ? '' : 'none';
    });
});

// ── QTY CHANGE ───────────────────────────────────────────
function changeQty(id, delta) {
    var el = document.getElementById(id);
    if (!el) return;
    var v = Math.max(1, (parseInt(el.value) || 1) + delta);
    el.value = v;
    recalcTotal();
}

// ── RECALC ───────────────────────────────────────────────
function recalcTotal() {
    var total = 0;
    document.querySelectorAll('.tiket-qty-row').forEach(function (row) {
        var check = row.querySelector('[data-tiket-check]');
        var harga = parseFloat(row.dataset.harga || 0);
        var sub   = row.querySelector('[data-subtotal]');
        if (!check || !check.checked) { if (sub) sub.textContent = 'Rp 0'; return; }
        var qtyEl = row.querySelector('[data-qty]');
        var qty   = qtyEl ? (parseInt(qtyEl.value) || 1) : 1;
        var s     = harga * qty;
        total += s;
        if (sub) sub.textContent = 'Rp ' + s.toLocaleString('id-ID');
    });
    document.querySelectorAll('#grand-total, #ringkasanTotal').forEach(function (el) {
        el.textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
}

// ── BUILD RINGKASAN ──────────────────────────────────────
function buildRingkasan() {
    var html = '';
    document.querySelectorAll('.tiket-qty-row').forEach(function (row) {
        var check = row.querySelector('[data-tiket-check]');
        if (!check || !check.checked) return;
        var nama  = row.querySelector('.fw-semibold')?.textContent?.trim() || '-';
        var harga = parseFloat(row.dataset.harga || 0);
        var qty   = parseInt(row.querySelector('[data-qty]')?.value || 1);
        html += '<div class="d-flex justify-content-between py-1 border-bottom"><span>' + nama + ' ×' + qty + '</span><span>Rp ' + (harga*qty).toLocaleString('id-ID') + '</span></div>';
    });
    document.getElementById('ringkasanContent').innerHTML = html || '<em>Belum ada tiket dipilih</em>';
}

// ── BUILD HIDDEN INPUTS ──────────────────────────────────
function buildHiddenInputs() {
    var container = document.getElementById('hiddenItemsContainer');
    container.innerHTML = '';
    var idx = 0;
    document.querySelectorAll('.tiket-qty-row').forEach(function (row) {
        var check = row.querySelector('[data-tiket-check]');
        if (!check || !check.checked) return;
        var id    = row.dataset.id;
        var tipe  = row.dataset.tipe;
        var qty   = parseInt(row.querySelector('[data-qty]')?.value || 1);
        container.innerHTML += '<input type="hidden" name="items[' + idx + '][tipe]" value="' + tipe + '">';
        container.innerHTML += '<input type="hidden" name="items[' + idx + '][id]" value="' + id + '">';
        container.innerHTML += '<input type="hidden" name="items[' + idx + '][jumlah]" value="' + qty + '">';
        idx++;
    });
}

// Form submit handler
document.getElementById('reservasiForm').addEventListener('submit', function () {
    buildHiddenInputs();
});
</script>
@endpush
