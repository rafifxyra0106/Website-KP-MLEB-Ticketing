<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $table    = 'informasi';
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'is_active', 'urutan'];
    protected $casts    = ['is_active' => 'boolean'];

    public function getGambarUrlAttribute(): string
    {
        return $this->gambar
            ? asset('images/informasi/' . $this->gambar)
            : asset('images/informasi/placeholder.png');
    }
}
