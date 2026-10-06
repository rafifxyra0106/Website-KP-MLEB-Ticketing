<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\KesanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JenisTiketController;
use App\Http\Controllers\Admin\BundlingTiketController;
use App\Http\Controllers\Admin\JadwalAdminController;
use App\Http\Controllers\Admin\ReservasiAdminController;
use App\Http\Controllers\Admin\PembayaranAdminController;
use App\Http\Controllers\Admin\TiketAdminController;
use App\Http\Controllers\Admin\KesanAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\InformasiAdminController;

// ── PUBLIC ──────────────────────────────────────────────────
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
Route::get('/informasi/{id}', [InformasiController::class, 'show'])->name('informasi.show');
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
Route::get('/jadwal/kuota', [JadwalController::class, 'kuota'])->name('jadwal.kuota');

// ── AUTH ────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── PENGUNJUNG (auth) ────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Reservasi
    Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/{id}', [ReservasiController::class, 'show'])->name('reservasi.show');
    Route::get('/reservasi/{id}/invoice', [ReservasiController::class, 'invoice'])->name('reservasi.invoice');
    Route::get('/riwayat', [ReservasiController::class, 'riwayat'])->name('riwayat');

    // Pembayaran
    Route::get('/pembayaran/{reservasiId}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{reservasiId}/pilih', [PembayaranController::class, 'pilihMetode'])->name('pembayaran.pilih');
    Route::post('/pembayaran/{id}/konfirmasi', [PembayaranController::class, 'konfirmasiManual'])->name('pembayaran.konfirmasi');

    // Tiket digital
    Route::get('/tiket/{kode}', [TiketController::class, 'show'])->name('tiket.show');
    Route::get('/tiket/{kode}/cetak', [TiketController::class, 'cetak'])->name('tiket.cetak');

    // Kesan pengunjung
    Route::get('/kesan', [KesanController::class, 'create'])->name('kesan.create');
    Route::post('/kesan', [KesanController::class, 'store'])->name('kesan.store');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    // AJAX helpers
    Route::get('/api/harga-tiket', [ReservasiController::class, 'getHargaTiket'])->name('api.harga_tiket');
    Route::get('/api/kuota-sesi', [ReservasiController::class, 'getKuotaSesi'])->name('api.kuota_sesi');
});

// ── ADMIN ────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Jenis Tiket
    Route::resource('jenis-tiket', JenisTiketController::class)->except(['show']);
    // Bundling Tiket
    Route::resource('bundling-tiket', BundlingTiketController::class)->except(['show']);

    // Jadwal
    Route::resource('jadwal', JadwalAdminController::class)->except(['show']);

    // Informasi
    Route::resource('informasi', InformasiAdminController::class)->except(['show']);

    // Reservasi
    Route::get('/reservasi', [ReservasiAdminController::class, 'index'])->name('reservasi.index');
    Route::get('/reservasi/{id}', [ReservasiAdminController::class, 'show'])->name('reservasi.show');
    Route::post('/reservasi/{id}/selesai', [ReservasiAdminController::class, 'selesai'])->name('reservasi.selesai');
    Route::post('/reservasi/{id}/batal', [ReservasiAdminController::class, 'batal'])->name('reservasi.batal');

    // Pembayaran
    Route::get('/pembayaran', [PembayaranAdminController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{id}', [PembayaranAdminController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}/konfirmasi', [PembayaranAdminController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
    Route::post('/pembayaran/{id}/tolak', [PembayaranAdminController::class, 'tolak'])->name('pembayaran.tolak');

    // Tiket Digital
    Route::get('/tiket', [TiketAdminController::class, 'index'])->name('tiket.index');
    Route::get('/tiket/{id}', [TiketAdminController::class, 'show'])->name('tiket.show');

    // Kesan Pengunjung
    Route::get('/kesan', [KesanAdminController::class, 'index'])->name('kesan.index');
    Route::post('/kesan/{id}/toggle', [KesanAdminController::class, 'toggle'])->name('kesan.toggle');
    Route::delete('/kesan/{id}', [KesanAdminController::class, 'destroy'])->name('kesan.destroy');

    // Users
    Route::resource('users', UserAdminController::class)->except(['show']);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
});
