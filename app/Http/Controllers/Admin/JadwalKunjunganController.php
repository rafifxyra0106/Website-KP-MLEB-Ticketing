<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKunjungan;
use Illuminate\Http\Request;

class JadwalKunjunganController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKunjungan::all();

        return view(
            'admin.jadwal.index',
            compact('jadwal')
        );
    }

    public function create()
    {
        return view(
            'admin.jadwal.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari_operasional' => 'required',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'kuota_harian' => 'required|integer',
            'harga_tiket' => 'required|numeric',
            'status' => 'required'
        ]);

        JadwalKunjungan::create(
            $request->all()
        );

        return redirect()
            ->route(
                'admin.jadwal.index'
            );
    }

    public function edit($id)
    {
        $jadwal = JadwalKunjungan::findOrFail($id);

        return view(
            'admin.jadwal.edit',
            compact('jadwal')
        );
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKunjungan::findOrFail($id);

        $jadwal->update(
            $request->all()
        );

        return redirect()
            ->route(
                'admin.jadwal.index'
            );
    }

    public function destroy($id)
    {
        JadwalKunjungan::destroy($id);

        return back();
    }
}