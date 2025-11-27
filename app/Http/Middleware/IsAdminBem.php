<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminBem
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini hanya mengizinkan akses untuk user dengan role 'adminbem' (super admin)
     * Digunakan untuk fitur-fitur yang hanya bisa diakses oleh super admin,
     * seperti user management, mengelola akun admin, dll.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            abort(403, 'Unauthorized - Please login first');
        }

        $user = auth()->user();

        // Hanya izinkan user dengan role 'adminbem'
        if (!$user->isAdminBem()) {
            abort(403, 'Access denied - Super Admin (AdminBEM) access required');
        }

        return $next($request);
    }
}
