<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KesanPengunjung extends Model
{
    protected $table    = 'kesan_pengunjung';
    protected $fillable = ['user_id', 'reservasi_id', 'nama_tampil', 'rating', 'pesan', 'is_visible'];
    protected $casts    = ['is_visible' => 'boolean', 'rating' => 'integer'];

    public function user()     { return $this->belongsTo(User::class); }
    public function reservasi(){ return $this->belongsTo(Reservasi::class); }

    public function getBintangAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
