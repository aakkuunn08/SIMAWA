<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsMahasiswa
{
    /**
     * Handle an incoming request.
     * Middleware untuk memastikan hanya mahasiswa (bukan admin) yang bisa akses
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user adalah admin atau adminbem
        if (auth()->check() && auth()->user()->isAnyAdmin()) {
            // Jika request adalah AJAX/JSON, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin tidak dapat mengisi tes minat.'
                ], 403);
            }
            
            // Jika request biasa, redirect ke dashboard dengan pesan error
            return redirect()->route('dashboard')
                ->with('error', 'Admin tidak dapat mengisi tes minat. Silakan gunakan halaman pengelolaan tes minat.');
        }

        return $next($request);
    }
}
