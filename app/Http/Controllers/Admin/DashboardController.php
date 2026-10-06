<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KesanPengunjung;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pengunjung'     => User::where('role', 'pengunjung')->count(),
            'total_reservasi'      => Reservasi::count(),
            'menunggu_pembayaran'  => Reservasi::where('status', 'menunggu_pembayaran')->count(),
            'terkonfirmasi'        => Reservasi::where('status', 'pembayaran_terkonfirmasi')->count(),
            'kunjungan_selesai'    => Reservasi::where('status', 'kunjungan_selesai')->count(),
            'total_pendapatan'     => Pembayaran::where('status', 'terkonfirmasi')->sum('total'),
            'pendapatan_bulan_ini' => Pembayaran::where('status', 'terkonfirmasi')
                ->whereMonth('dikonfirmasi_at', now()->month)
                ->whereYear('dikonfirmasi_at', now()->year)
                ->sum('total'),
        ];

        $reservasiTerbaru = Reservasi::with(['user', 'jadwal'])
            ->latest()->take(5)->get();

        $pembayaranMenunggu = Pembayaran::with(['reservasi.user'])
            ->where('status', 'menunggu')
            ->latest()->take(5)->get();

        // Grafik reservasi 7 hari terakhir
        $grafikData = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::now()->subDays($i);
            $grafikData[] = [
                'tanggal' => $tgl->format('d/m'),
                'jumlah'  => Reservasi::whereDate('created_at', $tgl)->count(),
            ];
        }

        return view('admin.dashboard', compact('stats', 'reservasiTerbaru', 'pembayaranMenunggu', 'grafikData'));
    }
}
