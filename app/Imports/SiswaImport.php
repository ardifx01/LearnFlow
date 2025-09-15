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
        // Normalisasi dan bersihkan value dari spasi kosong
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedKey = strtolower(str_replace(' ', '_', trim($key)));
            $normalizedRow[$normalizedKey] = trim($value);
        }

        // Validasi field penting (jika kosong, skip baris)
        $requiredFields = [
            'nama_lengkap',
            'nama_panggilan',
            'tanggal_lahir',
            'alamat',
            'nama_wali',
            'kontak',
            'kelas',
            'jenis_kelamin'
        ];

        foreach ($requiredFields as $field) {
            if (empty($normalizedRow[$field])) {
                return null; // Skip baris jika ada field penting yang kosong
            }
        }

        // Buat email wali (fallback jika kosong)
        $emailWali = !empty($normalizedRow['email']) 
            ? $normalizedRow['email'] 
            : strtolower(str_replace(' ', '', $normalizedRow['nama_wali'])) . '@gmail.com';

        // Buat akun user untuk wali siswa
        $user = User::create([
            'name'     => $normalizedRow['nama_wali'],
            'email'    => $emailWali,
            'password' => Hash::make('walisiswa123'), // Password default
            'role'     => 'wali_siswa',
        ]);

        // Simpan data wali siswa
        $wali = WaliSiswa::create([
            'users_id' => $user->id,
            'kontak'   => $normalizedRow['kontak'],
        ]);

        // Simpan data siswa
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
