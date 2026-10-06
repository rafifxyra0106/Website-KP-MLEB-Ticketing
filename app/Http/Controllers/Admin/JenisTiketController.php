<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisTiket;
use Illuminate\Http\Request;

class JenisTiketController extends Controller
{
    public function index()
    {
        $tiket = JenisTiket::orderBy('urutan')->get();
        return view('admin.tiket.jenis-index', compact('tiket'));
    }

    public function create()
    {
        return view('admin.tiket.jenis-form', ['tiket' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode'           => 'required|string|max:10|unique:jenis_tiket,kode',
            'nama'           => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'harga_weekday'  => 'required|numeric|min:0',
            'harga_weekend'  => 'required|numeric|min:0',
            'ikon'           => 'nullable|string|max:10',
            'urutan'         => 'nullable|integer',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file        = $request->file('gambar');
            $filename    = 'wahana_' . time() . '.' . $file->extension();
            $file->move(public_path('images/wahana'), $filename);
            $data['gambar'] = $filename;
        }

        $data['is_active'] = $request->boolean('is_active', true);
        JenisTiket::create($data);

        return redirect()->route('admin.jenis-tiket.index')
            ->with('success', 'Jenis tiket berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tiket = JenisTiket::findOrFail($id);
        return view('admin.tiket.jenis-form', compact('tiket'));
    }

    public function update(Request $request, $id)
    {
        $tiket = JenisTiket::findOrFail($id);
        $data  = $request->validate([
            'kode'           => 'required|string|max:10|unique:jenis_tiket,kode,' . $id,
            'nama'           => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'harga_weekday'  => 'required|numeric|min:0',
            'harga_weekend'  => 'required|numeric|min:0',
            'ikon'           => 'nullable|string|max:10',
            'urutan'         => 'nullable|integer',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($tiket->gambar && file_exists(public_path('images/wahana/' . $tiket->gambar))) {
                unlink(public_path('images/wahana/' . $tiket->gambar));
            }
            $file        = $request->file('gambar');
            $filename    = 'wahana_' . time() . '.' . $file->extension();
            $file->move(public_path('images/wahana'), $filename);
            $data['gambar'] = $filename;
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $tiket->update($data);

        return redirect()->route('admin.jenis-tiket.index')
            ->with('success', 'Jenis tiket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tiket = JenisTiket::findOrFail($id);
        if ($tiket->gambar && file_exists(public_path('images/wahana/' . $tiket->gambar))) {
            unlink(public_path('images/wahana/' . $tiket->gambar));
        }
        $tiket->delete();
        return back()->with('success', 'Jenis tiket berhasil dihapus.');
    }
}
