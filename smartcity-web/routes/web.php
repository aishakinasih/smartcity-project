<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page Utama (Bisa diakses siapa saja sebelum login)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// 2. Rute Autentikasi (Login & Register)
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
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
    // 1. Halaman Utama: Antrean Laporan AI (Menampilkan Tabel Saja)
    Route::get('/dashboard', [LaporanController::class, 'dashboard'])->name('laporan.dashboard');

    // 2. Halaman Terpisah: Grafik dan Statistik (Menampilkan Card Statistik Saja)
    Route::get('/dashboard/statistik', [LaporanController::class, 'statistik'])->name('laporan.statistik');

    // 3. Route Aksi: Update Status Laporan (Dipanggil saat select option berubah)
    Route::patch('/laporan/{id}/update-status', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
});