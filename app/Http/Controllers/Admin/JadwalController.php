<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKunjungan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKunjungan::orderBy('id')->get();

        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);
        JadwalKunjungan::create($data);

        return redirect()->route('admin.jadwal.index')->with('sukses', 'Jadwal operasional berhasil ditambahkan.');
    }

    public function edit(JadwalKunjungan $jadwal)
    {
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, JadwalKunjungan $jadwal)
    {
        $jadwal->update($this->validasi($request));

        return redirect()->route('admin.jadwal.index')->with('sukses', 'Jadwal operasional berhasil diperbarui.');
    }

    public function destroy(JadwalKunjungan $jadwal)
    {
        $jadwal->delete();

        return back()->with('sukses', 'Jadwal operasional berhasil dihapus.');
    }

    protected function validasi(Request $request): array
    {
        return $request->validate([
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'kuota' => ['required', 'integer', 'min:1'],
            'harga_tiket' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['aktif', 'tidak_aktif'])],
        ]);
    }
}
