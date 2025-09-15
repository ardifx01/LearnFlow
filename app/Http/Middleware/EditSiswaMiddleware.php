<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EditSiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $siswa = $request->route('siswa'); // Sudah berupa instance dari model Siswa

        // Jika user adalah admin, izinkan akses
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Jika user adalah wali_siswa, periksa apakah wali_id siswa cocok dengan user yang login
        if ($user->role === 'wali_siswa' && $user->waliSiswa && $user->waliSiswa->id === $siswa->wali_id) {
            return $next($request);
        }

        // Jika tidak memenuhi syarat, tolak akses
        abort(403, 'Anda tidak memiliki izin untuk mengedit data siswa ini.');
    }
}
