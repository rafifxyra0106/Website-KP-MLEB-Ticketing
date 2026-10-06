<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kesan_pesan', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('reservasi_kunjungan_id')
                ->constrained('reservasi_kunjungan')
                ->onDelete('cascade');

            $table->tinyInteger('rating');

            $table->text('pesan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kesan_pesan');
    }
};