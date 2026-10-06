<?php

namespace App\Http\Controllers;

use App\Models\KesanPesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesanPesanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reservasi_kunjungan_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'pesan' => 'required'
        ]);

        KesanPesan::create([
            'user_id' => Auth::id(),
            'reservasi_kunjungan_id' =>
                $request->reservasi_kunjungan_id,
            'rating' => $request->rating,
            'pesan' => $request->pesan
        ]);

        return back()
            ->with(
                'success',
                'Terima kasih atas masukan Anda'
            );
    }
}