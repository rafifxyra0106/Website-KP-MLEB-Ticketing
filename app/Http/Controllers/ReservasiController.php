<?php

namespace App\Http\Controllers;

use App\Models\BundlingTiket;
use App\Models\DetailReservasi;
use App\Models\JadwalKunjungan;
use App\Models\JenisTiket;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\TiketDigital;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    public function create(Request $request)
    {
        $jadwal   = JadwalKunjungan::where('is_active', true)->orderBy('urutan')->get();
        $tiket    = JenisTiket::where('is_active', true)->orderBy('urutan')->get();
        $bundling = BundlingTiket::where('is_active', true)->with('jenisTiket')->orderBy('urutan')->get();

        return view('pengunjung.reservasi', compact('jadwal', 'tiket', 'bundling'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kunjungan'  => 'required|date|after_or_equal:today',
            'jadwal_id'          => 'required|exists:jadwal_kunjungan,id',
            'jenis_kunjungan'    => 'required|in:individu,keluarga,rombongan_sekolah,rombongan_instansi',
            'nama_pemesan'       => 'required|string|max:255',
            'email_pemesan'      => 'required|email',
            'phone_pemesan'      => 'required|string|max:20',
            'jumlah_peserta'     => 'required|integer|min:1|max:500',
            'items'              => 'required|array|min:1',
            'items.*.tipe'       => 'required|in:satuan,bundling',
            'items.*.id'         => 'required|integer',
            'items.*.jumlah'     => 'required|integer|min:1',
        ], [
            'tanggal_kunjungan.required'  => 'Tanggal kunjungan wajib dipilih.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu.',
            'jadwal_id.required'          => 'Sesi kunjungan wajib dipilih.',
            'jenis_kunjungan.required'    => 'Jenis kunjungan wajib dipilih.',
            'nama_pemesan.required'       => 'Nama pemesan wajib diisi.',
            'email_pemesan.required'      => 'Email pemesan wajib diisi.',
            'phone_pemesan.required'      => 'Nomor telepon wajib diisi.',
            'jumlah_peserta.required'     => 'Jumlah peserta wajib diisi.',
            'items.required'              => 'Pilih minimal 1 tiket atau bundling.',
        ]);

        // Tambahan validasi rombongan
        if (in_array($request->jenis_kunjungan, ['rombongan_sekolah', 'rombongan_instansi'])) {
            $request->validate([
                'jumlah_peserta' => 'required|integer|min:10',
            ], ['jumlah_peserta.min' => 'Rombongan minimal 10 peserta.']);
        }

        $jadwal   = JadwalKunjungan::findOrFail($request->jadwal_id);
        $tipeHari = JadwalKunjungan::getTipeHari($request->tanggal_kunjungan);

        // Cek kuota
        $sisaKuota = $jadwal->getSisaKuota($request->tanggal_kunjungan);
        if ($sisaKuota < $request->jumlah_peserta) {
            return back()->withErrors(['jumlah_peserta' => "Kuota tidak mencukupi. Sisa kuota: $sisaKuota orang."])->withInput();
        }

        DB::beginTransaction();
        try {
            // Hitung total
            $totalHarga  = 0;
            $detailItems = [];

            foreach ($request->items as $item) {
                if ($item['tipe'] === 'satuan') {
                    $jenisTiket = JenisTiket::findOrFail($item['id']);
                    $harga      = $jenisTiket->getHarga($tipeHari);
                    $subtotal   = $harga * $item['jumlah'];
                    $totalHarga += $subtotal;
                    $detailItems[] = [
                        'jenis_tiket_id'   => $jenisTiket->id,
                        'bundling_tiket_id'=> null,
                        'tipe_item'        => 'satuan',
                        'nama_item'        => $jenisTiket->nama,
                        'jumlah'           => $item['jumlah'],
                        'harga_satuan'     => $harga,
                        'subtotal'         => $subtotal,
                    ];
                } else {
                    $bundling = BundlingTiket::findOrFail($item['id']);
                    $harga    = $bundling->getHarga($tipeHari);
                    $subtotal = $harga * $item['jumlah'];
                    $totalHarga += $subtotal;
                    $detailItems[] = [
                        'jenis_tiket_id'   => null,
                        'bundling_tiket_id'=> $bundling->id,
                        'tipe_item'        => 'bundling',
                        'nama_item'        => $bundling->nama,
                        'jumlah'           => $item['jumlah'],
                        'harga_satuan'     => $harga,
                        'subtotal'         => $subtotal,
                    ];
                }
            }

            // Buat reservasi
            $reservasi = Reservasi::create([
                'kode_reservasi'        => Reservasi::generateKode(),
                'user_id'               => Auth::id(),
                'jadwal_kunjungan_id'   => $jadwal->id,
                'tanggal_kunjungan'     => $request->tanggal_kunjungan,
                'tipe_hari'             => $tipeHari,
                'jenis_kunjungan'       => $request->jenis_kunjungan,
                'nama_pemesan'          => $request->nama_pemesan,
                'email_pemesan'         => $request->email_pemesan,
                'phone_pemesan'         => $request->phone_pemesan,
                'jumlah_peserta'        => $request->jumlah_peserta,
                'nama_instansi'         => $request->nama_instansi,
                'nama_sekolah'          => $request->nama_sekolah,
                'nama_guru_pendamping'  => $request->nama_guru_pendamping,
                'kelas_rombongan'       => $request->kelas_rombongan,
                'nama_pic_instansi'     => $request->nama_pic_instansi,
                'butuh_kursi_roda'      => $request->boolean('butuh_kursi_roda'),
                'jumlah_kursi_roda'     => $request->butuh_kursi_roda ? ($request->jumlah_kursi_roda ?? 1) : 0,
                'butuh_pemandu'         => $request->boolean('butuh_pemandu'),
                'bahasa_pemandu'        => $request->butuh_pemandu ? $request->bahasa_pemandu : null,
                'ada_balita'            => $request->boolean('ada_balita'),
                'jumlah_balita'         => $request->ada_balita ? ($request->jumlah_balita ?? 1) : 0,
                'catatan_khusus'        => $request->catatan_khusus,
                'total_harga'           => $totalHarga,
                'status'                => 'menunggu_pembayaran',
            ]);

            // Simpan detail
            foreach ($detailItems as $detail) {
                DetailReservasi::create(array_merge(['reservasi_id' => $reservasi->id], $detail));
            }

            DB::commit();

            return redirect()->route('pembayaran.show', $reservasi->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan pilih metode pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $reservasi = Reservasi::with(['detail', 'jadwal', 'pembayaran', 'tiketDigital'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pengunjung.reservasi-detail', compact('reservasi'));
    }

    public function invoice($id)
    {
        $reservasi = Reservasi::with(['detail', 'jadwal', 'pembayaran', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.invoice', compact('reservasi'));
        $pdf->setPaper('A4');

        return $pdf->stream('Invoice-' . $reservasi->kode_reservasi . '.pdf');
    }

    public function riwayat()
    {
        $reservasi = Reservasi::with(['jadwal', 'pembayaran', 'tiketDigital'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pengunjung.riwayat', compact('reservasi'));
    }

    // AJAX: harga tiket by tipe hari
    public function getHargaTiket(Request $request)
    {
        $tipeHari = $request->tipe_hari ?? 'weekday';
        $tiket    = JenisTiket::where('is_active', true)->orderBy('urutan')->get()->map(function ($t) use ($tipeHari) {
            return [
                'id'    => $t->id,
                'kode'  => $t->kode,
                'nama'  => $t->nama,
                'harga' => $t->getHarga($tipeHari),
                'ikon'  => $t->ikon,
            ];
        });
        $bundling = BundlingTiket::where('is_active', true)->orderBy('urutan')->get()->map(function ($b) use ($tipeHari) {
            return [
                'id'          => $b->id,
                'nama'        => $b->nama,
                'harga'       => $b->getHarga($tipeHari),
                'badge_label' => $b->badge_label,
                'isi'         => $b->jenisTiket->pluck('nama')->implode(', '),
            ];
        });
        return response()->json(['tiket' => $tiket, 'bundling' => $bundling]);
    }

    // AJAX: kuota sesi by tanggal
    public function getKuotaSesi(Request $request)
    {
        $tanggal = $request->tanggal;
        $sesi    = JadwalKunjungan::where('is_active', true)->orderBy('urutan')->get()->map(function ($j) use ($tanggal) {
            return [
                'id'         => $j->id,
                'nama_sesi'  => $j->nama_sesi,
                'jam'        => $j->jam,
                'sisa_kuota' => $j->getSisaKuota($tanggal),
            ];
        });
        return response()->json(['sesi' => $sesi, 'tipe_hari' => JadwalKunjungan::getTipeHari($tanggal)]);
    }
}
