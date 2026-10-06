<?php

namespace App\Http\Controllers;

use App\Models\KesanPengunjung;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesanController extends Controller
{
    public function create()
    {
        $reservasiSelesai = Reservasi::where('user_id', Auth::id())
            ->where('status', 'kunjungan_selesai')
            ->whereDoesntHave('kesan')
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();

        // Pengunjung yang belum pernah menyelesaikan kunjungan tidak boleh memberi rating asal-asalan.
        if ($reservasiSelesai->isEmpty()) {
            return redirect()->route('riwayat')
                ->with('error', 'Anda hanya dapat memberi kesan & ulasan setelah menyelesaikan kunjungan museum.');
        }

        return view('pengunjung.kesan', compact('reservasiSelesai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tampil'  => 'required|string|max:100',
            'rating'       => 'required|integer|min:1|max:5',
            'pesan'        => 'required|string|min:10|max:1000',
            'reservasi_id' => 'required|exists:reservasi,id',
        ], [
            'nama_tampil.required'  => 'Nama tampil wajib diisi.',
            'rating.required'       => 'Rating wajib dipilih.',
            'pesan.required'        => 'Kesan/pesan wajib diisi.',
            'pesan.min'             => 'Kesan minimal 10 karakter.',
            'pesan.max'             => 'Kesan maksimal 1000 karakter.',
            'reservasi_id.required' => 'Pilih kunjungan yang ingin Anda beri ulasan.',
            'reservasi_id.exists'   => 'Kunjungan tidak valid.',
        ]);

        // Pastikan reservasi benar-benar milik user, sudah selesai, dan belum pernah diberi kesan.
        $reservasi = Reservasi::where('id', $request->reservasi_id)
            ->where('user_id', Auth::id())
            ->where('status', 'kunjungan_selesai')
            ->whereDoesntHave('kesan')
            ->first();

        if (! $reservasi) {
            return back()->withInput()
                ->with('error', 'Anda hanya dapat memberi ulasan untuk kunjungan yang sudah selesai dan belum pernah diberi ulasan.');
        }

        KesanPengunjung::create([
            'user_id'      => Auth::id(),
            'reservasi_id' => $reservasi->id,
            'nama_tampil'  => $request->nama_tampil,
            'rating'       => $request->rating,
            'pesan'        => $request->pesan,
            'is_visible'   => true,
        ]);

        return redirect()->route('beranda')
            ->with('success', 'Terima kasih atas kesan dan pesan Anda! Ulasan Anda sudah tampil di halaman utama.');
    }
}
