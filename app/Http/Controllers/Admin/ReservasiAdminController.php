<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\TiketDigital;
use Illuminate\Http\Request;

class ReservasiAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user', 'jadwal', 'pembayaran']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis_kunjungan', $request->jenis);
        }
        if ($request->filled('tanggal')) {
            $query->where('tanggal_kunjungan', $request->tanggal);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sq) use ($q) {
                $sq->where('kode_reservasi', 'like', "%$q%")
                   ->orWhere('nama_pemesan', 'like', "%$q%")
                   ->orWhere('phone_pemesan', 'like', "%$q%");
            });
        }

        $reservasi = $query->latest()->paginate(15)->withQueryString();
        return view('admin.reservasi.index', compact('reservasi'));
    }

    public function show($id)
    {
        $reservasi = Reservasi::with(['user', 'jadwal', 'detail.jenisTiket', 'detail.bundlingTiket', 'pembayaran', 'tiketDigital'])->findOrFail($id);
        return view('admin.reservasi.show', compact('reservasi'));
    }

    public function selesai(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        if ($reservasi->status !== 'pembayaran_terkonfirmasi') {
            return back()->with('error', 'Status reservasi tidak memungkinkan untuk diselesaikan.');
        }
        $reservasi->update(['status' => 'kunjungan_selesai']);

        if ($reservasi->tiketDigital) {
            $reservasi->tiketDigital->update(['status' => 'digunakan', 'digunakan_at' => now()]);
        }

        return back()->with('success', 'Kunjungan telah ditandai selesai.');
    }

    public function batal(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status' => 'dibatalkan']);
        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
