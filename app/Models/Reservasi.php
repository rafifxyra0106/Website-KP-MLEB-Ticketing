<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    protected $fillable = [
        'kode_reservasi', 'user_id', 'jadwal_kunjungan_id',
        'tanggal_kunjungan', 'tipe_hari',
        'jenis_kunjungan', 'nama_pemesan', 'email_pemesan', 'phone_pemesan', 'jumlah_peserta',
        'nama_instansi', 'nama_sekolah', 'nama_guru_pendamping', 'kelas_rombongan', 'nama_pic_instansi',
        'butuh_kursi_roda', 'jumlah_kursi_roda',
        'butuh_pemandu', 'bahasa_pemandu',
        'ada_balita', 'jumlah_balita',
        'catatan_khusus', 'total_harga', 'status',
    ];
    protected $casts = [
        'tanggal_kunjungan'  => 'date',
        'butuh_kursi_roda'   => 'boolean',
        'butuh_pemandu'      => 'boolean',
        'ada_balita'         => 'boolean',
        'total_harga'        => 'decimal:2',
    ];

    public function user()           { return $this->belongsTo(User::class); }
    public function jadwal()         { return $this->belongsTo(JadwalKunjungan::class, 'jadwal_kunjungan_id'); }
    public function detail()         { return $this->hasMany(DetailReservasi::class); }
    public function pembayaran()     { return $this->hasOne(Pembayaran::class); }
    public function tiketDigital()   { return $this->hasOne(TiketDigital::class); }
    public function kesan()          { return $this->hasOne(KesanPengunjung::class); }

    public static function generateKode(): string
    {
        $prefix = 'MLEB-' . date('Ymd') . '-';
        $last   = static::where('kode_reservasi', 'like', $prefix . '%')->count() + 1;
        return $prefix . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function getLabelStatusAttribute(): string
    {
        return match($this->status) {
            'menunggu_pembayaran'       => 'Menunggu Pembayaran',
            'pembayaran_terkonfirmasi'  => 'Pembayaran Dikonfirmasi',
            'kunjungan_selesai'         => 'Kunjungan Selesai',
            'dibatalkan'                => 'Dibatalkan',
            default                     => ucfirst($this->status),
        };
    }

    public function getLabelJenisAttribute(): string
    {
        return match($this->jenis_kunjungan) {
            'individu'           => 'Individu',
            'keluarga'           => 'Keluarga',
            'rombongan_sekolah'  => 'Rombongan Sekolah',
            'rombongan_instansi' => 'Rombongan Instansi',
            default              => ucfirst($this->jenis_kunjungan),
        };
    }

    public function getBadgeStatusAttribute(): string
    {
        return match($this->status) {
            'menunggu_pembayaran'       => 'warning',
            'pembayaran_terkonfirmasi'  => 'info',
            'kunjungan_selesai'         => 'success',
            'dibatalkan'                => 'danger',
            default                     => 'secondary',
        };
    }
}
