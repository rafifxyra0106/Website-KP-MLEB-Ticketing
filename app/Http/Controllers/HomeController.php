<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\ShowcaseAlat;
use App\Models\KesanPesan;

class HomeController extends Controller
{
    public function index()
    {
        $informasi = Informasi::latest()
            ->take(3)
            ->get();

        $showcase = ShowcaseAlat::where(
            'status',
            true
        )
        ->latest()
        ->take(6)
        ->get();

        $kesanPesan = KesanPesan::latest()
            ->take(5)
            ->get();

        return view(
            'home',
            compact(
                'informasi',
                'showcase',
                'kesanPesan'
            )
        );
    }
}