<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice', function (Blueprint $table) {

            $table->id();

            $table->foreignId('reservasi_kunjungan_id')
                ->constrained('reservasi_kunjungan')
                ->onDelete('cascade');

            $table->string('nomor_invoice');

            $table->string('file_pdf')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};