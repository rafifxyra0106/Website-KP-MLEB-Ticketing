<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanLaporan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /** Revisi #7: pengaturan nama, jabatan, dan tanda tangan manajer untuk laporan PDF */
    public function edit()
    {
        $pengaturan = PengaturanLaporan::current();

        return view('admin.pengaturan.edit', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = PengaturanLaporan::current();

        $data = $request->validate([
            'nama_manajer' => ['required', 'string', 'max:100'],
            'jabatan' => ['required', 'string', 'max:150'],
            'tanda_tangan' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('tanda_tangan')) {
            $nama = time() . '_ttd.' . $request->file('tanda_tangan')->getClientOriginalExtension();
            $request->file('tanda_tangan')->move(public_path('images/ttd'), $nama);
            $data['tanda_tangan'] = $nama;
        }

        $pengaturan->update($data);

        return back()->with('sukses', 'Pengaturan tanda tangan laporan berhasil disimpan.');
    }
}
