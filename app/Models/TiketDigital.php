<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TiketDigital extends Model
{
    protected $table    = 'tiket_digital';
    protected $fillable = ['reservasi_id', 'user_id', 'kode_tiket', 'gambar_qr', 'status', 'digunakan_at'];
    protected $casts    = ['digunakan_at' => 'datetime'];

    public function reservasi() { return $this->belongsTo(Reservasi::class); }
    public function user()      { return $this->belongsTo(User::class); }

    public static function generateKode(int $reservasiId): string
    {
        return 'TKT-' . strtoupper(Str::random(8)) . '-' . $reservasiId;
    }

    public function getGambarQrUrlAttribute(): string
    {
        return $this->gambar_qr
            ? asset('images/tiket/' . $this->gambar_qr)
            : '';
    }
}
