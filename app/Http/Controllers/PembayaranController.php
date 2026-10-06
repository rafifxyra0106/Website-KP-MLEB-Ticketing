<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\TiketDigital;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function show($reservasiId)
    {
        $reservasi  = Reservasi::with(['detail', 'jadwal', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->findOrFail($reservasiId);

        return view('pengunjung.pembayaran', compact('reservasi'));
    }

    public function pilihMetode(Request $request, $reservasiId)
    {
        $request->validate([
            'metode' => 'required|in:bca_va,mandiri_va,bni_va,bri_va,qris',
        ], [
            'metode.required' => 'Pilih metode pembayaran terlebih dahulu.',
            'metode.in'       => 'Metode pembayaran tidak valid.',
        ]);

        $reservasi = Reservasi::where('user_id', Auth::id())
            ->where('status', 'menunggu_pembayaran')
            ->findOrFail($reservasiId);

        // Hapus pembayaran lama jika ada
        if ($reservasi->pembayaran) {
            $reservasi->pembayaran->delete();
        }

        $metode    = $request->metode;
        $nomorVA   = null;
        $kodeQris  = null;
        $gambarQris= null;

        if ($metode === 'qris') {
            $kodeQris   = 'MLEB-QRIS-' . $reservasi->id . '-' . time();
            $gambarQris = 'qris-placeholder.png'; // placeholder
        } else {
            $nomorVA = Pembayaran::generateNomorVA($metode, $reservasi->id);
        }

        $pembayaran = Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'metode'       => $metode,
            'nomor_va'     => $nomorVA,
            'kode_qris'    => $kodeQris,
            'gambar_qris'  => $gambarQris,
            'total'        => $reservasi->total_harga,
            'status'       => 'menunggu',
            'expired_at'   => Carbon::now()->addHours(24),
        ]);

        return redirect()->route('pembayaran.show', $reservasiId)
            ->with('success', 'Metode pembayaran berhasil dipilih. Selesaikan pembayaran sebelum ' . $pembayaran->expired_at->format('d/m/Y H:i') . ' WIB.');
    }

    // Simulasi konfirmasi manual (pengunjung klik "Saya Sudah Bayar")
    public function konfirmasiManual(Request $request, $id)
    {
        $pembayaran = Pembayaran::with('reservasi')->findOrFail($id);

        if ($pembayaran->reservasi->user_id !== Auth::id()) {
            abort(403);
        }

        if ($pembayaran->status !== 'menunggu') {
            return back()->with('error', 'Status pembayaran tidak valid.');
        }

        // Simulasi: langsung konfirmasi (tanpa verifikasi nyata)
        $pembayaran->update([
            'status'          => 'terkonfirmasi',
            'dikonfirmasi_at' => Carbon::now(),
        ]);

        $reservasi = $pembayaran->reservasi;
        $reservasi->update(['status' => 'pembayaran_terkonfirmasi']);

        // Generate tiket digital
        if (!$reservasi->tiketDigital) {
            TiketDigital::create([
                'reservasi_id' => $reservasi->id,
                'user_id'      => $reservasi->user_id,
                'kode_tiket'   => TiketDigital::generateKode($reservasi->id),
                'gambar_qr'    => null,
                'status'       => 'aktif',
            ]);
        }

        return redirect()->route('reservasi.show', $reservasi->id)
            ->with('success', 'Pembayaran dikonfirmasi! Tiket digital Anda sudah siap.');
    }
}
