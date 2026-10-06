<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShowcaseAlat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShowcaseController extends Controller
{
    public function index()
    {
        $showcase = ShowcaseAlat::orderBy('urutan')->paginate(10);

        return view('admin.showcase.index', compact('showcase'));
    }

    public function create()
    {
        return view('admin.showcase.create');
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);

        if ($request->hasFile('gambar')) {
            $nama = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move(public_path('images/showcase'), $nama);
            $data['gambar'] = $nama;
        }

        ShowcaseAlat::create($data);

        return redirect()->route('admin.showcase.index')->with('sukses', 'Showcase alat berhasil ditambahkan.');
    }

    public function edit(ShowcaseAlat $showcase)
    {
        return view('admin.showcase.edit', compact('showcase'));
    }

    public function update(Request $request, ShowcaseAlat $showcase)
    {
        $data = $this->validasi($request);

        if ($request->hasFile('gambar')) {
            $nama = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move(public_path('images/showcase'), $nama);
            $data['gambar'] = $nama;
        }

        $showcase->update($data);

        return redirect()->route('admin.showcase.index')->with('sukses', 'Showcase alat berhasil diperbarui.');
    }

    public function destroy(ShowcaseAlat $showcase)
    {
        $showcase->delete();

        return back()->with('sukses', 'Showcase alat berhasil dihapus.');
    }

    protected function validasi(Request $request): array
    {
        return $request->validate([
            'nama_alat' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string'],
            'cocok_untuk' => ['required', Rule::in(['sekolah', 'keluarga', 'individu', 'semua'])],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'status_aktif' => ['nullable', 'boolean'],
        ]) + ['status_aktif' => $request->boolean('status_aktif', true), 'urutan' => $request->urutan ?? 0];
    }
}
