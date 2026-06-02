<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (Auth::check()) {
            $role = Auth::user()->role;

            // Jika dia superadmin atau admin_instansi, izinkan lewat ke halaman admin
            if ($role === 'superadmin' || $role === 'admin_instansi') {
                return $next($request);
            }
        }

        // Jika bukan admin, tendang balik ke halaman home/form pengaduan dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}