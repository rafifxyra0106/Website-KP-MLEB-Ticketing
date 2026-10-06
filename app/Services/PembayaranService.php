<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\ReservasiKunjungan;
use App\Models\Tiket;

class PembayaranService
{
    public const BANK_VA = ['BCA', 'BNI', 'MANDIRI', 'BRI'];

    /**
     * Membuat record pembayaran baru sesuai metode yang dipilih pengunjung.
     * Revisi #4: hanya QRIS & Virtual Account, tanpa upload bukti pembayaran.
     */
    public function buatPembayaran(ReservasiKunjungan $reservasi, string $metode, ?string $bank = null): Pembayaran
    {
        $data = [
            'reservasi_kunjungan_id' => $reservasi->id,
            'kode_pembayaran' => KodeGenerator::kodePembayaran(),
            'metode_pembayaran' => $metode,
            'jumlah_bayar' => $reservasi->total_harga,
            'batas_waktu_pembayaran' => now()->addHours(24),
            'status' => 'menunggu_pembayaran',
        ];

        if ($metode === 'virtual_account') {
            $bank = $bank ?: self::BANK_VA[0];
            $data['bank_va'] = $bank;
            $data['nomor_va'] = KodeGenerator::nomorVa($bank);
        }

        return Pembayaran::create($data);
    }

    /**
     * Saat pembayaran diverifikasi LUNAS oleh admin, terbitkan e-tiket otomatis.
     * Revisi #8: tiket untuk ditunjukkan saat sampai museum.
     */
    public function terbitkanTiket(ReservasiKunjungan $reservasi): Tiket
    {
        return Tiket::firstOrCreate(
            ['reservasi_kunjungan_id' => $reservasi->id],
            ['kode_tiket' => KodeGenerator::kodeTiket(), 'status' => 'belum_digunakan']
        );
    }
}
