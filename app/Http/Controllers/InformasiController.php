<?php

namespace App\Http\Controllers;

use App\Models\Informasi;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::where('is_active', true)->orderBy('urutan')->get();
        return view('pengunjung.informasi', compact('informasi'));
    }

    public function show($id)
    {
        $info = Informasi::where('is_active', true)->findOrFail($id);
        return view('pengunjung.informasi-detail', compact('info'));
    }
}
