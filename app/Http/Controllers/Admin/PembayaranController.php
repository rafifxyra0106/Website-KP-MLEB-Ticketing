<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran =
            Pembayaran::latest()->get();

        return view(
            'admin.pembayaran.index',
            compact('pembayaran')
        );
    }
}