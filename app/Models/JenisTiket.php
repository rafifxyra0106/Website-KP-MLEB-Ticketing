<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTiket extends Model
{
    protected $table    = 'jenis_tiket';
    protected $fillable = [
        'kode', 'nama', 'deskripsi',
        'harga_weekday', 'harga_weekend',
        'gambar', 'ikon', 'is_active', 'urutan'
    ];
    protected $casts = [
        'is_active'      => 'boolean',
        'harga_weekday'  => 'decimal:2',
        'harga_weekend'  => 'decimal:2',
    ];

    public function bundlings()
    {
        return $this->belongsToMany(BundlingTiket::class, 'bundling_tiket_detail', 'jenis_tiket_id', 'bundling_tiket_id');
    }

    public function getHarga(string $tipeHari): float
    {
        return $tipeHari === 'weekend' ? (float)$this->harga_weekend : (float)$this->harga_weekday;
    }

    public function getGambarUrlAttribute(): string
    {
        return $this->gambar
            ? asset('images/wahana/' . $this->gambar)
            : asset('images/wahana/placeholder.png');
    }
}
