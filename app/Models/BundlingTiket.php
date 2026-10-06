<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundlingTiket extends Model
{
    protected $table    = 'bundling_tiket';
    protected $fillable = [
        'nama', 'deskripsi',
        'harga_weekday', 'harga_weekend',
        'gambar', 'badge_label', 'is_active', 'urutan'
    ];
    protected $casts = [
        'is_active'     => 'boolean',
        'harga_weekday' => 'decimal:2',
        'harga_weekend' => 'decimal:2',
    ];

    public function jenisTiket()
    {
        return $this->belongsToMany(JenisTiket::class, 'bundling_tiket_detail', 'bundling_tiket_id', 'jenis_tiket_id');
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
