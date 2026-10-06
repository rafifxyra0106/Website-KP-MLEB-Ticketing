<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\JenisTiket;
use App\Models\BundlingTiket;
use App\Models\KesanPengunjung;

class BerandaController extends Controller
{
    public function index()
    {
        $wahana    = JenisTiket::where('is_active', true)->orderBy('urutan')->get();
        $bundling  = BundlingTiket::where('is_active', true)->with('jenisTiket')->orderBy('urutan')->get();
        $kesan     = KesanPengunjung::where('is_visible', true)->latest()->take(6)->get();
        $informasi = Informasi::where('is_active', true)->orderBy('urutan')->take(3)->get();

        return view('pengunjung.beranda', compact('wahana', 'bundling', 'kesan', 'informasi'));
    }
}
