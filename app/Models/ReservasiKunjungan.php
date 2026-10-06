<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservasiKunjungan extends Model
{
    protected $table = 'reservasi_kunjungan';

    protected $fillable = [
        'kode_reservasi',
        'user_id',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'jenis_kunjungan',
        'nama_instansi',
        'penanggung_jawab',
        'telepon',
        'jumlah_peserta',
        'jumlah_tiket',
        'total_harga',
        'tujuan_kunjungan',
        'transportasi',
        'kebutuhan_khusus',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function tiket()
    {
        return $this->hasOne(Tiket::class);
    }

    public function kesanPesan()
    {
        return $this->hasOne(KesanPesan::class);
    }
}