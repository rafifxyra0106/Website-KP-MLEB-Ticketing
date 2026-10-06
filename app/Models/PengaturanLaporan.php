<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanLaporan extends Model
{
    protected $table = 'pengaturan_laporan';

    protected $fillable = ['nama_manajer', 'jabatan', 'tanda_tangan'];

    public static function current(): self
    {
        return self::firstOrCreate([], ['jabatan' => 'Manajer Museum Listrik dan Energi Baru']);
    }
}
