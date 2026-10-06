<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\TiketDigital;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PembayaranAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['reservasi.user']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }
        $pembayaran = $query->latest()->paginate(15)->withQueryString();
        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with(['reservasi.user', 'reservasi.detail', 'reservasi.jadwal'])->findOrFail($id);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $pembayaran = Pembayaran::with('reservasi')->findOrFail($id);

        $pembayaran->update([
            'status'          => 'terkonfirmasi',
            'dikonfirmasi_at' => Carbon::now(),
            'catatan_admin'   => $request->catatan_admin,
        ]);

        $reservasi = $pembayaran->reservasi;
        $reservasi->update(['status' => 'pembayaran_terkonfirmasi']);

        if (!$reservasi->tiketDigital) {
            TiketDigital::create([
                'reservasi_id' => $reservasi->id,
                'user_id'      => $reservasi->user_id,
                'kode_tiket'   => TiketDigital::generateKode($reservasi->id),
                'status'       => 'aktif',
            ]);
        }

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi dan tiket digital telah dibuat.');
    }

    public function tolak(Request $request, $id)
    {
        $pembayaran = Pembayaran::with('reservasi')->findOrFail($id);
        $pembayaran->update([
            'status'        => 'dibatalkan',
            'catatan_admin' => $request->catatan_admin,
        ]);
        $pembayaran->reservasi->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Pembayaran telah ditolak.');
    }
}
