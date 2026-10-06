<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi_kunjungan', function (Blueprint $table) {

            $table->id();

            $table->string('kode_reservasi')->unique();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->date('tanggal_kunjungan');

            $table->time('jam_kunjungan');

            $table->enum('jenis_kunjungan', [
                'Individu',
                'Keluarga',
                'Sekolah',
                'Mahasiswa',
                'Instansi Pemerintah',
                'Perusahaan',
                'Komunitas'
            ]);

            $table->string('nama_instansi')->nullable();

            $table->string('penanggung_jawab');

            $table->string('telepon');

            $table->integer('jumlah_peserta');

            $table->integer('jumlah_tiket');

            $table->decimal('total_harga', 12, 2);

            $table->enum('tujuan_kunjungan', [
                'Wisata Edukasi',
                'Study Tour',
                'Penelitian',
                'Kunjungan Industri',
                'Kegiatan Komunitas',
                'Lainnya'
            ]);

            $table->string('transportasi')->nullable();

            $table->text('kebutuhan_khusus')->nullable();

            $table->enum('status', [
                'Menunggu Pembayaran',
                'Menunggu Verifikasi',
                'Disetujui',
                'Selesai',
                'Ditolak'
            ])->default('Menunggu Pembayaran');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_kunjungan');
    }
};