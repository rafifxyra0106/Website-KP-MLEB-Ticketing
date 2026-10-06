<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalReservasi = $user->reservasi()->count();
        $totalSelesai   = $user->reservasi()->where('status', 'kunjungan_selesai')->count();
        return view('pengunjung.profil', compact('user', 'totalReservasi', 'totalSelesai'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);
        $user->update($request->only('name', 'email', 'phone', 'address'));
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password baru minimal 8 karakter.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
