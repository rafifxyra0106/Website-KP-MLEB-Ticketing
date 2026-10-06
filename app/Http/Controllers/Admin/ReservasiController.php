<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReservasiKunjungan;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasi =
            ReservasiKunjungan::latest()->get();

        return view(
            'admin.reservasi.index',
            compact('reservasi')
        );
    }

    public function show($id)
    {
        $reservasi =
            ReservasiKunjungan::findOrFail($id);

        return view(
            'admin.reservasi.show',
            compact('reservasi')
        );
    }

    public function setujui($id)
    {
        ReservasiKunjungan::findOrFail($id)
            ->update([
                'status' => 'Disetujui'
            ]);

        return back();
    }

    public function tolak($id)
    {
        ReservasiKunjungan::findOrFail($id)
            ->update([
                'status' => 'Ditolak'
            ]);

        return back();
    }
}