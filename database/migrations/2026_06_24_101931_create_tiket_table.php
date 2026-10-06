<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket', function (Blueprint $table) {

            $table->id();

            $table->foreignId('reservasi_kunjungan_id')
                ->constrained('reservasi_kunjungan')
                ->onDelete('cascade');

            $table->string('kode_tiket')->unique();

            $table->string('qr_code')->nullable();

            $table->dateTime('tanggal_terbit')->nullable();

            $table->enum('status', [
                'Aktif',
                'Digunakan',
                'Kadaluarsa'
            ])->default('Aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};