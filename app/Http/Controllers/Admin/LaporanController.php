<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $query = Reservasi::with([
            'user',
            'jadwal',
            'pembayaran'
        ])
        ->whereYear('tanggal_kunjungan', $tahun)
        ->whereMonth('tanggal_kunjungan', $bulan);

        if ($request->filled('jenis')) {
            $query->where(
                'jenis_kunjungan',
                $request->jenis
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $reservasi = $query
            ->orderBy('tanggal_kunjungan')
            ->get();

        $stats = [
            'total' => $reservasi->count(),

            'selesai' => $reservasi
                ->where('status', 'kunjungan_selesai')
                ->count(),

            'terkonfirmasi' => $reservasi
                ->where('status', 'pembayaran_terkonfirmasi')
                ->count(),

            'total_peserta' => $reservasi
                ->sum('jumlah_peserta'),

            'pendapatan' => $reservasi
                ->whereIn('status', [
                    'pembayaran_terkonfirmasi',
                    'kunjungan_selesai'
                ])
                ->sum('total_harga')
        ];

        $tahunList = range(
            date('Y'),
            date('Y') - 4
        );

        $bulanNama = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return view(
            'admin.laporan.index',
            compact(
                'reservasi',
                'stats',
                'bulan',
                'tahun',
                'tahunList',
                'bulanNama'
            )
        );
    }

    public function exportPdf(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $namaManajer = $request->nama_manajer ?? '';
        $jabatan     = $request->jabatan ?? 'Manajer Museum';

        $query = Reservasi::with([
            'user',
            'jadwal',
            'pembayaran'
        ])
        ->whereYear('tanggal_kunjungan', $tahun)
        ->whereMonth('tanggal_kunjungan', $bulan);

        if ($request->filled('jenis')) {
            $query->where(
                'jenis_kunjungan',
                $request->jenis
            );
        }

        $reservasi = $query
            ->orderBy('tanggal_kunjungan')
            ->get();

        $stats = [
            'total' => $reservasi->count(),

            'selesai' => $reservasi
                ->where('status', 'kunjungan_selesai')
                ->count(),

            'total_peserta' => $reservasi
                ->sum('jumlah_peserta'),

            'pendapatan' => $reservasi
                ->whereIn('status', [
                    'pembayaran_terkonfirmasi',
                    'kunjungan_selesai'
                ])
                ->sum('total_harga')
        ];

        $bulanNama = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $pdf = app('dompdf.wrapper');

        $pdf->loadView(
            'pdf.laporan',
            compact(
                'reservasi',
                'stats',
                'bulan',
                'tahun',
                'bulanNama',
                'namaManajer',
                'jabatan'
            )
        );

        $pdf->setPaper(
            'A4',
            'landscape'
        );

        return $pdf->stream(
            "Laporan-Kunjungan-{$bulanNama[$bulan]}-{$tahun}.pdf"
        );
    }
}