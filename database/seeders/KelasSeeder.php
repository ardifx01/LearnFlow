<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $waliKelas = DB::table('wali_kelas')->pluck('id')->toArray();

        $kelas = [
            ['nama' => 'Kelas KB', 'guru_id' => $waliKelas[0] ?? null],
            ['nama' => 'Kelas A', 'guru_id' => $waliKelas[1] ?? null],
            ['nama' => 'Kelas B1', 'guru_id' => $waliKelas[2] ?? null],
            ['nama' => 'Kelas B2', 'guru_id' => $waliKelas[3] ?? null],
        ];

        DB::table('kelas')->insert(array_filter($kelas, fn($k) => $k['guru_id'] !== null));
    }
}
