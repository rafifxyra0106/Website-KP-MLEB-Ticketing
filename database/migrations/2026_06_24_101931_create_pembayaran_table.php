<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {

            $table->id();

            $table->foreignId('reservasi_kunjungan_id')
                ->constrained('reservasi_kunjungan')
                ->onDelete('cascade');

            $table->enum('metode_pembayaran', [
                'QRIS',
                'Virtual Account'
            ]);

            $table->string('nomor_virtual_account')
                ->nullable();

            $table->decimal('jumlah_bayar', 12, 2);

            $table->dateTime('tanggal_pembayaran')
                ->nullable();

            $table->enum('status', [
                'Pending',
                'Dibayar',
                'Ditolak'
            ])->default('Pending');

            $table->text('catatan_admin')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};