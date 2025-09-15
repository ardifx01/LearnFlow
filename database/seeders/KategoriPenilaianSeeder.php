<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Doa Sehari-Hari'],
            ['nama' => 'Bacaan Sholat'],
            ['nama' => 'Kalimat Thayyibah'],
            ['nama' => 'Asmaul Husna'],
            ['nama' => 'Hadits Sehari-Hari'],
            ['nama' => 'Sholawat'],
            ['nama' => 'Surat-Surat Pendek'],
        ];

        DB::table('kategori_penilaian')->insert($data);
    }
}
