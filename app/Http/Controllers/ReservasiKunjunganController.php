<?php

namespace App\Http\Controllers;

use App\Models\ReservasiKunjungan;
use App\Models\JadwalKunjungan;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservasiKunjunganController extends Controller
{
    public function index()
    {
        $reservasi = ReservasiKunjungan::where(
            'user_id',
            Auth::id()
        )->latest()->get();

        return view(
            'reservasi.index',
            compact('reservasi')
        );
    }

    public function create()
    {
        $jadwal = JadwalKunjungan::where(
            'status',
            'buka'
        )->get();

        return view(
            'reservasi.create',
            compact('jadwal')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required',

            'jenis_kunjungan' => 'required',

            'penanggung_jawab' => 'required',

            'telepon' => 'required',

            'jumlah_peserta' => 'required|integer|min:1',

            'jumlah_tiket' => 'required|integer|min:1',

            'tujuan_kunjungan' => 'required',

            'keterangan_tambahan' => 'nullable|array',
            'catatan_tambahan' => 'nullable|string|max:200'
        ]);

        $hargaTiket = JadwalKunjungan::first()->harga_tiket;

        $totalHarga =
            $hargaTiket *
            $request->jumlah_tiket;

        // Gabungkan kategori keterangan tambahan (checkbox) + catatan singkat
        // menjadi satu nilai yang rapi untuk disimpan di kolom kebutuhan_khusus.
        $kategori = $request->input('keterangan_tambahan', []);
        $catatan = trim((string) $request->input('catatan_tambahan'));

        $kebutuhanKhusus = null;
        if (!empty($kategori)) {
            $kebutuhanKhusus = implode(', ', $kategori);
        }
        if ($catatan !== '') {
            $kebutuhanKhusus = $kebutuhanKhusus
                ? $kebutuhanKhusus . ' — ' . $catatan
                : $catatan;
        }

        $reservasi = ReservasiKunjungan::create([

            'kode_reservasi' =>
                'RSV-' . strtoupper(uniqid()),

            'user_id' =>
                Auth::id(),

            'tanggal_kunjungan' =>
                $request->tanggal_kunjungan,

            'jam_kunjungan' =>
                $request->jam_kunjungan,

            'jenis_kunjungan' =>
                $request->jenis_kunjungan,

            'nama_instansi' =>
                $request->nama_instansi,

            'penanggung_jawab' =>
                $request->penanggung_jawab,

            'telepon' =>
                $request->telepon,

            'jumlah_peserta' =>
                $request->jumlah_peserta,

            'jumlah_tiket' =>
                $request->jumlah_tiket,

            'total_harga' =>
                $totalHarga,

            'tujuan_kunjungan' =>
                $request->tujuan_kunjungan,

            'transportasi' =>
                $request->transportasi,

            'kebutuhan_khusus' =>
                $kebutuhanKhusus,

            'status' =>
                'Menunggu Pembayaran'
        ]);

        Invoice::create([
            'reservasi_kunjungan_id' => $reservasi->id,
            'nomor_invoice' => 'INV-' . date('Ymd') . '-' . $reservasi->id
        ]);

        return redirect()
            ->route('pembayaran.index');
    }

        public function show($id)
        {
            $reservasi = ReservasiKunjungan::where(
                'user_id',
                Auth::id()
            )->findOrFail($id);

            return view(
                'reservasi.show',
                compact('reservasi')
            );
        }

    public function riwayat()
    {
        $riwayat = ReservasiKunjungan::where(
            'user_id',
            Auth::id()
        )->latest()->get();

        return view(
            'reservasi.riwayat',
            compact('riwayat')
        );
    }
}