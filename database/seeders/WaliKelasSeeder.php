<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WaliKelasSeeder extends Seeder
{
    public function run()
    {
        $waliKelas = [
            [
                'name' => 'Lutfiyah, S.Pd',
                'email' => 'lutfiyah@gmail.com',
                'password' => Hash::make('walikelas123'),
                'role' => 'wali_kelas',
                'kontak' => '087750717688',
            ],
            [
                'name' => 'Siti Aisyah',
                'email' => 'siti@example.com',
                'password' => Hash::make('walikelas123'),
                'role' => 'wali_kelas',
                'kontak' => '081234567891',
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko@example.com',
                'password' => Hash::make('walikelas123'),
                'role' => 'wali_kelas',
                'kontak' => '081234567892',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'password' => Hash::make('walikelas123'),
                'role' => 'wali_kelas',
                'kontak' => '081234567893',
            ],
        ];

        foreach ($waliKelas as $wali) {
            $user = User::updateOrCreate(
                ['email' => $wali['email']],
                [
                    'name' => $wali['name'],
                    'password' => $wali['password'],
                    'role' => $wali['role'],
                ]
            );

            DB::table('wali_kelas')->updateOrInsert(
                ['users_id' => $user->id],
                [
                    'kontak' => $wali['kontak'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}