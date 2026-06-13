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

    public function showProfile()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user(); 
        return view('laporan.profile', compact('user'));
    }

    // 2. Memproses Update Profil / Password
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'current_password' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed', // 'confirmed' memastikan cocok dengan password_confirmation
        ]);

        // Cek apakah password saat ini benar
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Kata sandi sekarang yang Anda masukkan salah.']);
        }

        // Update nama
        $user->name = $request->name;

        // Jika user mengisi password baru, update password-nya
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success_profile', 'Profil dan kata sandi berhasil diperbarui!');
    }

    // 3. Memproses Hapus Akun
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        // Logout user terlebih dahulu
        Auth::logout();

        // Hapus data user dari database
        $user->delete();

        // Invalidasi session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success_delete', 'Akun Anda telah berhasil dihapus secara permanen.');
    }
}