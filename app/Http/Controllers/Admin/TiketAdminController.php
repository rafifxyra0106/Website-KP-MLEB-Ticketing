<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TiketDigital;
use Illuminate\Http\Request;

class TiketAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = TiketDigital::with(['reservasi.user', 'reservasi.jadwal']);
        if ($request->filled('status')) $query->where('status', $request->status);
        $tiket = $query->latest()->paginate(15)->withQueryString();
        return view('admin.tiket.digital-index', compact('tiket'));
    }
    public function show($id)
    {
        $tiket = TiketDigital::with(['reservasi.detail', 'reservasi.jadwal', 'user'])->findOrFail($id);
        return view('admin.tiket.digital-show', compact('tiket'));
    }
}
