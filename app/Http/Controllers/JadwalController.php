<?php

namespace App\Http\Controllers;

use App\Models\JadwalKunjungan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKunjungan::where('is_active', true)->orderBy('urutan')->get();
        return view('pengunjung.jadwal', compact('jadwal'));
    }

    public function kuota(Request $request)
    {
        $tanggal = $request->tanggal ?? today()->format('Y-m-d');
        $jadwal  = JadwalKunjungan::where('is_active', true)->orderBy('urutan')->get()->map(function ($j) use ($tanggal) {
            return [
                'id'         => $j->id,
                'nama_sesi'  => $j->nama_sesi,
                'jam'        => $j->jam,
                'sisa_kuota' => $j->getSisaKuota($tanggal),
                'tipe_hari'  => JadwalKunjungan::getTipeHari($tanggal),
            ];
        });
        return response()->json($jadwal);
    }
}
