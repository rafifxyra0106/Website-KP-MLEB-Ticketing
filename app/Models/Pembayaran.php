<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table    = 'pembayaran';
    protected $fillable = [
        'reservasi_id', 'metode', 'nomor_va', 'kode_qris', 'gambar_qris',
        'total', 'status', 'expired_at', 'dikonfirmasi_at', 'catatan_admin',
    ];
    protected $casts = [
        'total'           => 'decimal:2',
        'expired_at'      => 'datetime',
        'dikonfirmasi_at' => 'datetime',
    ];

    public function reservasi() { return $this->belongsTo(Reservasi::class); }

    public function getLabelMetodeAttribute(): string
    {
        return match($this->metode) {
            'bca_va'     => 'Virtual Account BCA',
            'mandiri_va' => 'Virtual Account Mandiri',
            'bni_va'     => 'Virtual Account BNI',
            'bri_va'     => 'Virtual Account BRI',
            'qris'       => 'QRIS',
            default      => strtoupper($this->metode),
        };
    }

    public function getNamaBankAttribute(): string
    {
        return match($this->metode) {
            'bca_va'     => 'BCA',
            'mandiri_va' => 'Mandiri',
            'bni_va'     => 'BNI',
            'bri_va'     => 'BRI',
            default      => '',
        };
    }

    public static function generateNomorVA(string $metode, int $reservasiId): string
    {
        $prefix = match($metode) {
            'bca_va'     => '8277',
            'mandiri_va' => '8888',
            'bni_va'     => '9889',
            'bri_va'     => '8881',
            default      => '9999',
        };
        return $prefix . str_pad($reservasiId, 10, '0', STR_PAD_LEFT) . rand(10, 99);
    }
}
