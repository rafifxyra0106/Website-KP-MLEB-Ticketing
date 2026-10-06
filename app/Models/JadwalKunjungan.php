<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalKunjungan extends Model
{
    protected $table    = 'jadwal_kunjungan';
    protected $fillable = [
        'nama_sesi', 'jam_mulai', 'jam_selesai',
        'kuota_weekday', 'kuota_weekend',
        'is_active', 'urutan'
    ];
    protected $casts = ['is_active' => 'boolean'];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }

    public function getSisaKuota(string $tanggal): int
    {
        $tipeHari  = $this->getTipeHari($tanggal);
        $kuota     = $tipeHari === 'weekend' ? $this->kuota_weekend : $this->kuota_weekday;
        $terpakai  = $this->reservasi()
            ->where('tanggal_kunjungan', $tanggal)
            ->whereIn('status', ['menunggu_pembayaran', 'pembayaran_terkonfirmasi'])
            ->sum('jumlah_peserta');
        return max(0, $kuota - $terpakai);
    }

    public static function getTipeHari(string $tanggal): string
    {
        $hari = Carbon::parse($tanggal)->dayOfWeek;
        return in_array($hari, [Carbon::SATURDAY, Carbon::SUNDAY]) ? 'weekend' : 'weekday';
    }

    public function getJamAttribute(): string
    {
        return Carbon::parse($this->jam_mulai)->format('H:i')
             . ' – '
             . Carbon::parse($this->jam_selesai)->format('H:i');
    }
}
