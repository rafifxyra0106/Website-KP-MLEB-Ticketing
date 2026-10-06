<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kunjungan', function (Blueprint $table) {

            $table->id();

            $table->string('hari_operasional');

            $table->time('jam_buka');

            $table->time('jam_tutup');

            $table->integer('kuota_harian');

            $table->decimal('harga_tiket', 12, 2);

            $table->enum('status', [
                'buka',
                'tutup'
            ])->default('buka');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_kunjungan');
    }
};