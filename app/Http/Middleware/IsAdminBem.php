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
     * Menggunakan Spatie Laravel Permission dengan fallback ke legacy system
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

        // Cek menggunakan Spatie's hasRole() method
        // Dengan fallback ke legacy system untuk backward compatibility
        if (!$user->hasRole('adminbem') && !$user->isAdminBem()) {
            abort(403, 'Access denied - Super Admin (AdminBEM) access required');
        }

        return $next($request);
    }
}
