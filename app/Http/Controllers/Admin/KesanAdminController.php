<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\KesanPengunjung;
use Illuminate\Http\Request;

class KesanAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = KesanPengunjung::with('user');
        if ($request->filled('rating')) $query->where('rating', $request->rating);
        $kesan = $query->latest()->paginate(15)->withQueryString();
        return view('admin.kesan.index', compact('kesan'));
    }
    public function toggle($id)
    {
        $kesan = KesanPengunjung::findOrFail($id);
        $kesan->update(['is_visible' => !$kesan->is_visible]);
        $status = $kesan->is_visible ? 'ditampilkan' : 'disembunyikan';
        return back()->with('success', "Ulasan berhasil $status.");
    }
    public function destroy($id)
    {
        KesanPengunjung::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
