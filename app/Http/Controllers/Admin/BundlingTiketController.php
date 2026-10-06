<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BundlingTiket;
use App\Models\JenisTiket;
use Illuminate\Http\Request;

class BundlingTiketController extends Controller
{
    public function index()
    {
        $bundling = BundlingTiket::with('jenisTiket')->orderBy('urutan')->get();
        return view('admin.tiket.bundling-index', compact('bundling'));
    }

    public function create()
    {
        $semuaTiket = JenisTiket::where('is_active', true)->orderBy('urutan')->get();
        return view('admin.tiket.bundling-form', ['bundling' => null, 'semuaTiket' => $semuaTiket]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'           => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'harga_weekday'  => 'required|numeric|min:0',
            'harga_weekend'  => 'required|numeric|min:0',
            'badge_label'    => 'nullable|string|max:50',
            'urutan'         => 'nullable|integer',
            'tiket_ids'      => 'required|array|min:1',
            'tiket_ids.*'    => 'exists:jenis_tiket,id',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $bundling = BundlingTiket::create($data);
        $bundling->jenisTiket()->sync($request->tiket_ids);

        return redirect()->route('admin.bundling-tiket.index')
            ->with('success', 'Bundling tiket berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bundling   = BundlingTiket::with('jenisTiket')->findOrFail($id);
        $semuaTiket = JenisTiket::where('is_active', true)->orderBy('urutan')->get();
        return view('admin.tiket.bundling-form', compact('bundling', 'semuaTiket'));
    }

    public function update(Request $request, $id)
    {
        $bundling = BundlingTiket::findOrFail($id);
        $data     = $request->validate([
            'nama'           => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'harga_weekday'  => 'required|numeric|min:0',
            'harga_weekend'  => 'required|numeric|min:0',
            'badge_label'    => 'nullable|string|max:50',
            'urutan'         => 'nullable|integer',
            'tiket_ids'      => 'required|array|min:1',
            'tiket_ids.*'    => 'exists:jenis_tiket,id',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $bundling->update($data);
        $bundling->jenisTiket()->sync($request->tiket_ids);

        return redirect()->route('admin.bundling-tiket.index')
            ->with('success', 'Bundling tiket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        BundlingTiket::findOrFail($id)->delete();
        return back()->with('success', 'Bundling tiket berhasil dihapus.');
    }
}
