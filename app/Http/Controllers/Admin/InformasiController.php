<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::latest()->get();

        return view(
            'admin.informasi.index',
            compact('informasi')
        );
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image'
        ]);

        $gambar = null;

        if ($request->hasFile('gambar'))
        {
            $file = $request->file('gambar');

            $gambar = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('images'),
                $gambar
            );
        }

        Informasi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        return redirect()
            ->route('admin.informasi.index')
            ->with(
                'success',
                'Informasi berhasil ditambahkan'
            );
    }

    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);

        return view(
            'admin.informasi.edit',
            compact('informasi')
        );
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $gambar = $informasi->gambar;

        if ($request->hasFile('gambar'))
        {
            $file = $request->file('gambar');

            $gambar = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('images'),
                $gambar
            );
        }

        $informasi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        return redirect()
            ->route('admin.informasi.index');
    }

    public function destroy($id)
    {
        Informasi::findOrFail($id)
            ->delete();

        return back();
    }
}