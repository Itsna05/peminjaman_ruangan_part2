<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {

        // VALIDASI
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Username atau password salah!'
            ]);
        }

        // SIMPAN SESSION (BENAR)
        $request->session()->put([
            'user_id' => $user->id_user,
            'username' => $user->username,
            'role' => $user->role,
        ]);

        $request->session()->regenerate();

        // REDIRECT SESUAI ROLE
        if ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect()->route('login');



    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
