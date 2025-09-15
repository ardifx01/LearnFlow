<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\WaliSiswa;
use App\Models\User;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Normalisasi header agar sesuai dengan format yang bisa digunakan di PHP
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedKey = strtolower(str_replace(' ', '_', trim($key))); // "NAMA WALI" -> "nama_wali"
            $normalizedRow[$normalizedKey] = $value;
        }

        // Pastikan email wali tidak kosong
        $emailWali = !empty($normalizedRow['email']) ? $normalizedRow['email'] : strtolower(str_replace(' ', '', $normalizedRow['nama_wali'])) . '@gmail.com';

        // Buat Akun User untuk Wali Siswa
        $user = User::create([
            'name'     => $normalizedRow['nama_wali'],
            'email'    => $emailWali,
            'password' => Hash::make('walisiswa123'), // Default password
            'role'     => 'wali_siswa',
        ]);

        // Simpan Data Wali Siswa
        $wali = WaliSiswa::create([
            'users_id' => $user->id,
            'kontak'   => $normalizedRow['kontak'],
        ]);

        // Simpan Data Siswa
        return new Siswa([
            'nama_lengkap'   => $normalizedRow['nama_lengkap'],
            'nama_panggilan' => $normalizedRow['nama_panggilan'],
            'tetala'         => $normalizedRow['tanggal_lahir'],
            'alamat'         => $normalizedRow['alamat'],
            'wali_id'        => $wali->id,
            'kelas_id'       => $normalizedRow['kelas'], 
            'jk'             => $normalizedRow['jenis_kelamin'],
        ]);
    }
}
