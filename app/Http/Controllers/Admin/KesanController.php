<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KesanPengunjung;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KesanController extends Controller
{
    public function index()
    {
        $kesan = KesanPengunjung::latest()->paginate(10);

        return view('admin.kesan.index', compact('kesan'));
    }

    public function create()
    {
        return view('admin.kesan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pengunjung' => ['required', 'string', 'max:100'],
            'asal_rombongan' => ['nullable', 'string', 'max:150'],
            'pesan' => ['required', 'string', 'max:500'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $nama = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('images/kesan'), $nama);
            $data['foto'] = $nama;
        }

        $data['status'] = 'ditampilkan';
        KesanPengunjung::create($data);

        return redirect()->route('admin.kesan.index')->with('sukses', 'Kesan pengunjung berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, KesanPengunjung $kesan)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['menunggu', 'ditampilkan', 'disembunyikan'])]]);
        $kesan->update($data);

        return back()->with('sukses', 'Status kesan pengunjung diperbarui.');
    }

    public function destroy(KesanPengunjung $kesan)
    {
        $kesan->delete();

        return back()->with('sukses', 'Kesan pengunjung dihapus.');
    }
}
