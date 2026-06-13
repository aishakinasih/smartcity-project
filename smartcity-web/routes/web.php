<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Models\Laporan; // Tambahkan ini agar bisa memanggil model Laporan
use Illuminate\Support\Facades\Route;

// 1. Landing Page Utama dengan Data Statistik Grafik
Route::get('/', function () {
    $totalMasuk   = Laporan::where('status', 'Masuk')->count();
    $totalDiproses = Laporan::where('status', 'Diproses')->count();
    $totalSelesai  = Laporan::where('status', 'Selesai')->count();
    $totalSemua    = $totalMasuk + $totalDiproses + $totalSelesai;

    return view('landing', compact('totalMasuk', 'totalDiproses', 'totalSelesai', 'totalSemua'));
})->name('landing');

// 2. Rute Autentikasi (LOGIN & REGISTER SEKARANG DIPISAH)
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); // Penyesuaian: Rute untuk nampilin blade register
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Rute yang WAJIB LOGIN baru bisa dibuka (Middleware Auth)
Route::middleware('auth')->group(function () {
    
    // Halaman Form Pengaduan Masyarakat
    Route::get('/lapor', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/kirim', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/riwayat-saya', [LaporanController::class, 'riwayatUser'])->name('laporan.riwayat');
    
    // RUTE PROFIL PENGGUNA
    Route::get('/profil', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::put('/profil/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profil/delete', [AuthController::class, 'deleteAccount'])->name('profile.delete');
    
    // Halaman Dashboard Admin
    Route::get('/dashboard', [LaporanController::class, 'dashboard'])->name('laporan.dashboard');
    Route::get('/dashboard/statistik', [LaporanController::class, 'statistik'])->name('laporan.statistik');
    Route::patch('/laporan/{id}/update-status', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
});