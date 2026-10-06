<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKunjungan;
use Illuminate\Http\Request;

class JadwalAdminController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKunjungan::orderBy('urutan')->get();
        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        return view('admin.jadwal.form', ['jadwal' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi'      => 'required|string|max:100',
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'kuota_weekday'  => 'required|integer|min:1',
            'kuota_weekend'  => 'required|integer|min:1',
            'urutan'         => 'nullable|integer',
        ]);

        $data = $request->only('nama_sesi', 'jam_mulai', 'jam_selesai', 'kuota_weekday', 'kuota_weekend', 'urutan');
        $data['is_active'] = $request->boolean('is_active', true);
        JadwalKunjungan::create($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Sesi jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalKunjungan::findOrFail($id);
        return view('admin.jadwal.form', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKunjungan::findOrFail($id);
        $request->validate([
            'nama_sesi'     => 'required|string|max:100',
            'jam_mulai'     => 'required',
            'jam_selesai'   => 'required',
            'kuota_weekday' => 'required|integer|min:1',
            'kuota_weekend' => 'required|integer|min:1',
        ]);

        $data = $request->only('nama_sesi', 'jam_mulai', 'jam_selesai', 'kuota_weekday', 'kuota_weekend', 'urutan');
        $data['is_active'] = $request->boolean('is_active', true);
        $jadwal->update($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Sesi jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        JadwalKunjungan::findOrFail($id)->delete();
        return back()->with('success', 'Sesi jadwal berhasil dihapus.');
    }
}
