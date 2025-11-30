<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini mengizinkan akses untuk user dengan role 'adminukm' atau 'adminbem'
     * - 'adminbem': Super Admin (akses penuh)
     * - 'adminukm': Admin UKM/SC (akses terbatas)
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

        // Cek menggunakan Spatie's hasAnyRole() method
        // Dengan fallback ke legacy system untuk backward compatibility
        if (!$user->hasAnyRole(['adminukm', 'adminbem']) && !$user->isAnyAdmin() && $user->is_admin !== 1) {
            abort(403, 'Access denied - Admin access required');
        }

        return $next($request);
    }
}
