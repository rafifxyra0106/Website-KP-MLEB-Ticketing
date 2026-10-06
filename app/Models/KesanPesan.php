<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KesanPesan extends Model
{
    protected $table = 'kesan_pesan';

    protected $fillable = [
        'user_id',
        'reservasi_kunjungan_id',
        'rating',
        'pesan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservasi()
    {
        return $this->belongsTo(
            ReservasiKunjungan::class,
            'reservasi_kunjungan_id'
        );
    }
}