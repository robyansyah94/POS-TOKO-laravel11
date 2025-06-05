<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Ganti manual field yang dipakai attempt()
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        // Cek autentikasi
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect sesuai dengan role pengguna
            if ($user->role === 'admin') {
                return redirect('/produk');  // Halaman awal admin
            }

            if ($user->role === 'kasir') {
                return redirect('/kasir');  // Halaman awal kasir
            }

            abort(403, 'Unauthorized role.');
        }



        // Tambahkan flash log untuk debugging
        return back()->withErrors([
            'username' => 'These credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
