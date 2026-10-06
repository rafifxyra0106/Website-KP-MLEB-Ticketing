<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\ReservasiKunjungan;
use App\Models\Tiket;
use Illuminate\Support\Str;

class KodeGenerator
{
    public static function kodeReservasi(): string
    {
        do {
            $kode = 'MLEB-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        } while (ReservasiKunjungan::where('kode_reservasi', $kode)->exists());

        return $kode;
    }

    public static function kodePembayaran(): string
    {
        do {
            $kode = 'PAY-' . now()->format('ymd') . '-' . strtoupper(Str::random(5));
        } while (Pembayaran::where('kode_pembayaran', $kode)->exists());

        return $kode;
    }

    public static function nomorVa(string $bank): string
    {
        $prefix = match ($bank) {
            'BCA' => '3901', 'BNI' => '8807', 'MANDIRI' => '8855', 'BRI' => '2611', default => '0000',
        };

        return $prefix . str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    }

    public static function kodeTiket(): string
    {
        do {
            $kode = 'TKT-' . strtoupper(Str::random(8));
        } while (Tiket::where('kode_tiket', $kode)->exists());

        return $kode;
    }
}
