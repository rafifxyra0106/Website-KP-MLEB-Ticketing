<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiAdminController extends Controller
{
    public function index() { return view('admin.informasi.index', ['informasi' => Informasi::orderBy('urutan')->paginate(10)]); }
    public function create() { return view('admin.informasi.form', ['info' => null]); }
    public function store(Request $request)
    {
        $data = $request->validate(['judul'=>'required','deskripsi'=>'required','urutan'=>'nullable|integer','gambar'=>'nullable|image|mimes:jpg,jpeg,png|max:2048']);
        if ($request->hasFile('gambar')) { $f=$request->file('gambar'); $fn='info_'.time().'.'.$f->extension(); $f->move(public_path('images/informasi'),$fn); $data['gambar']=$fn; }
        $data['is_active'] = $request->boolean('is_active', true);
        Informasi::create($data);
        return redirect()->route('admin.informasi.index')->with('success','Informasi berhasil ditambahkan.');
    }
    public function edit($id) { return view('admin.informasi.form', ['info' => Informasi::findOrFail($id)]); }
    public function update(Request $request, $id)
    {
        $info = Informasi::findOrFail($id);
        $data = $request->validate(['judul'=>'required','deskripsi'=>'required','urutan'=>'nullable|integer','gambar'=>'nullable|image|mimes:jpg,jpeg,png|max:2048']);
        if ($request->hasFile('gambar')) { if($info->gambar && file_exists(public_path('images/informasi/'.$info->gambar))) unlink(public_path('images/informasi/'.$info->gambar)); $f=$request->file('gambar'); $fn='info_'.time().'.'.$f->extension(); $f->move(public_path('images/informasi'),$fn); $data['gambar']=$fn; }
        $data['is_active'] = $request->boolean('is_active', true);
        $info->update($data);
        return redirect()->route('admin.informasi.index')->with('success','Informasi berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $info = Informasi::findOrFail($id);
        if ($info->gambar && file_exists(public_path('images/informasi/'.$info->gambar))) unlink(public_path('images/informasi/'.$info->gambar));
        $info->delete();
        return back()->with('success','Informasi berhasil dihapus.');
    }
}
