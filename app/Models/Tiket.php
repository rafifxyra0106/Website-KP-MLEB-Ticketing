<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tiket';

    protected $fillable = [
        'reservasi_kunjungan_id',
        'kode_tiket',
        'qr_code',
        'status'
    ];

    public function reservasi()
    {
        return $this->belongsTo(ReservasiKunjungan::class, 'reservasi_kunjungan_id');
    }
}