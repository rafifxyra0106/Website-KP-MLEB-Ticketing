<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class PenggunaController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view(
            'admin.pengguna.index',
            compact('users')
        );
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view(
            'admin.pengguna.show',
            compact('user')
        );
    }

    public function destroy($id)
    {
        User::findOrFail($id)
            ->delete();

        return back();
    }
}