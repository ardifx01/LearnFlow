<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        // Ambil role user dari database
        $userRole = Auth::user()->role; // Pastikan ada kolom `role` di tabel users

        // Cek apakah role user diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
