<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('beranda');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [], ['email' => 'Email', 'password' => 'Kata Sandi']);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return Auth::user()->isAdmin()
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended(route('beranda'))->with('sukses', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors(['email' => 'Email atau kata sandi yang Anda masukkan salah.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('beranda');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'no_telepon' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [], [
            'name' => 'Nama', 'email' => 'Email', 'no_telepon' => 'No. Telepon', 'password' => 'Kata Sandi',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_telepon' => $data['no_telepon'],
            'password' => Hash::make($data['password']),
            'role' => 'pengunjung',
        ]);

        Auth::login($user);

        return redirect()->route('beranda')->with('sukses', 'Pendaftaran berhasil! Selamat datang di MLEB, ' . $user->name . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sukses', 'Anda telah keluar. Sampai jumpa kembali!');
    }
}
