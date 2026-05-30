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
    
    // Halaman Dashboard Admin
    Route::get('/admin/dashboard', [LaporanController::class, 'dashboard'])->name('laporan.dashboard');
});