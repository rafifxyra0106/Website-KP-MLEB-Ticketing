<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'reservasi_kunjungan_id',
        'nomor_invoice'
    ];

    public function reservasi()
    {
        return $this->belongsTo(ReservasiKunjungan::class, 'reservasi_kunjungan_id');
    }
}