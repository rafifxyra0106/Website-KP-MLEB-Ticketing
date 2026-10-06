<?php

namespace App\Http\Controllers;

use App\Models\TiketDigital;
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
{
    public function show($kode)
    {
        $tiket = TiketDigital::with(['reservasi.detail', 'reservasi.jadwal', 'user'])
            ->where('kode_tiket', $kode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pengunjung.tiket', compact('tiket'));
    }

    public function cetak($kode)
    {
        $tiket = TiketDigital::with(['reservasi.detail', 'reservasi.jadwal', 'user'])
            ->where('kode_tiket', $kode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.tiket', compact('tiket'));
        $pdf->setPaper([0, 0, 400, 600], 'portrait');

        return $pdf->stream('Tiket-' . $tiket->kode_tiket . '.pdf');
    }
}
