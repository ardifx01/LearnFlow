<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Kelas;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\Auth;

class CekAksesEditPenilaian
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $penilaian = Penilaian::find($request->route('penilaian')); // Ambil ID dari route

        // Jika penilaian tidak ditemukan, kembalikan 404
        if (!$penilaian) {
            abort(404, 'Data penilaian tidak ditemukan.');
        }

        // Jika user adalah admin, izinkan akses tanpa pengecekan
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Jika user adalah wali_kelas, cek apakah siswa berada di kelas yang diampu
        if ($user->role === 'wali_kelas') {
            // Cari wali_kelas berdasarkan users_id
            $waliKelas = WaliKelas::where('users_id', $user->id)->first();
        
            // Jika user tidak terdaftar sebagai wali_kelas, tolak akses
            if (!$waliKelas) {
                abort(403, 'Anda tidak memiliki izin untuk mengedit penilaian ini.');
            }
        
            // Ambil kelas yang diampu wali_kelas
            $kelasWali = Kelas::where('guru_id', $waliKelas->id)->pluck('id')->toArray();
        
            // Cek apakah siswa berada di kelas yang diampu
            if (!in_array($penilaian->siswa->kelas_id, $kelasWali)) {
                abort(403, 'Anda tidak memiliki izin untuk mengedit penilaian ini.');
            }
        }

        return $next($request);
    }
}
