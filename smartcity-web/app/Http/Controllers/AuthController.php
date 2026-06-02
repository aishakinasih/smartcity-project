<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman Login & Register (Satu halaman split)
    public function showAuthForm()
    {
        return view('auth.login');
    }

    // Memproses Registrasi Akun Baru
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success_reg', 'Registrasi berhasil! Silakan login.');
    }

    // Memproses Login User
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil data user yang baru saja berhasil login
            $user = Auth::user();

            // JIKA YANG LOGIN ADALAH SUPERADMIN ATAU ADMIN INSTANSI
            if ($user->role === 'superadmin' || $user->role === 'admin_instansi') {
                return redirect()->route('laporan.dashboard');
            }

            // JIKA USER BIASA, KE HALAMAN FORM PENGADUAN
            return redirect()->route('laporan.index');
        }

        return redirect()->back()->withErrors([
            'login_error' => 'Email atau password yang kamu masukkan salah.',
        ]);
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }
}