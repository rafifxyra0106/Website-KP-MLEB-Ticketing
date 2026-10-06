<?php

namespace App\Http\Controllers;

use App\Models\JadwalKunjungan;

class JadwalKunjunganController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKunjungan::where(
            'status',
            'buka'
        )->get();

        return view(
            'jadwal.index',
            compact('jadwal')
        );
    }
}