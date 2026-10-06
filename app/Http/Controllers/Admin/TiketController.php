<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;

class TiketController extends Controller
{
    public function index()
    {
        $tiket = Tiket::latest()->get();

        return view(
            'admin.tiket.index',
            compact('tiket')
        );
    }

    public function show($id)
    {
        $tiket = Tiket::findOrFail($id);

        return view(
            'admin.tiket.show',
            compact('tiket')
        );
    }

    public function gunakan($id)
    {
        $tiket = Tiket::findOrFail($id);

        $tiket->update([
            'status' => 'Digunakan'
        ]);

        return back();
    }

    public function kadaluarsa($id)
    {
        $tiket = Tiket::findOrFail($id);

        $tiket->update([
            'status' => 'Kadaluarsa'
        ]);

        return back();
    }
}