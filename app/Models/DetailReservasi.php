<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReservasi extends Model
{
    protected $table    = 'detail_reservasi';
    protected $fillable = [
        'reservasi_id', 'jenis_tiket_id', 'bundling_tiket_id',
        'tipe_item', 'nama_item', 'jumlah', 'harga_satuan', 'subtotal',
    ];
    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal'     => 'decimal:2',
    ];

    public function reservasi()     { return $this->belongsTo(Reservasi::class); }
    public function jenisTiket()    { return $this->belongsTo(JenisTiket::class); }
    public function bundlingTiket() { return $this->belongsTo(BundlingTiket::class); }
}
