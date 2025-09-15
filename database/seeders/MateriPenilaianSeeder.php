<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materi = [
            1 => [ // Doa Sehari-Hari
                'Doa Kedua Orang Tua', 'Doa Sapu Jagat', 'Doa Mau Makan', 'Doa Setelah Makan', 'Doa Mau Tidur',
                'Doa Bangun Tidur', 'Doa Bercermin', 'Doa Masuk WC', 'Doa Keluar WC', 'Doa ketika Turun Hujan',
                'Doa Mendengar Petir', 'Doa Naik Kendaraan', 'Doa Masuk Rumah', 'Doa Keluar Rumah',
                'Doa Adab Ketika Bersin', 'Doa Sesudah Wudlu', 'Doa Memakai Pakaian', 'Doa Melepas Pakaian',
                'Doa Masuk Masjid', 'Doa Keluar Masjid', 'Doa Mendengar Adzan', 'Doa Sesudah Iqamah'
            ],
            2 => [ // Bacaan Sholat
                'Syahadat', 'Niat Sholat Fardlu', 'Doa Iftitah', 'Bacaan Ruku dan  Itidal',
                'Bacaan Sujud & Bacaan Antara 2 Sujud', 'Bacaan Tasyahud'
            ],
            3 => [ // Kalimat Thayyibah
                'Assalamualaikum wr.wb (Dengan Arti)', 'Taawwudz (Dengan Arti)', 'Basmalah (Dengan Arti)',
                'Hamdalah (Dengan Arti)', 'Takbir (Dengan Arti)', 'Tasbih/Subhanallah (Dengan Arti)',
                'Insyaallah (Dengan Arti)', 'Istighfar (Dengan Arti)', 'Masayaallah (Dengan Arti)',
                'Hauqalah (Dengan Arti)', 'Istirja (Dengan Arti)'
            ],
            4 => [ // Asmaul Husna
                'Asmaul Husna 1-25', 'Asmaul Husna 25-50', 'Asmaul Husna 1-50', 'Asmaul Husna 50-75', 'Asmaul Husna 75-99', 'Asmaul Husna 1-99'
            ],
            5 => [ // Hadits Sehari-Hari
                'Hadits Tentang Kasih Sayang', 'Hadits Tentang Akhlak', 'Hadits Tentang Keutamaan Bersuci',
                'Hadits Tentang Rumahku Surgaku', 'Hadits Tentang Kedudukan Ibu', 'Hadits Tentang Restu Orang Tua',
                'Hadits Tentang Kewajiban Menuntut Ilmu', 'Hadits Tentang Keutamaan Mempelajari Al-Quran',
                'Hadits Tentang Larangan Marah', 'Hadits Tentang Adab Makan dan Minum', 'Hadits Tentang Keutamaan Salam',
                'Hadits Tentang Adab Berbicara'
            ],
            6 => [ // Sholawat
                'Sholawat Pendek', 'Sholawat Syifa', 'Sholawat Nariyah', 'Sholawat Busyro'
            ],
            7 => [ // Surat-Surat Pendek
                'Al-Fatihah', 'Al-Ikhlas', 'Al-Falaq', 'An-Nas', 'Al-Kafirun', 'Al-Maun', 'Al-Kautsar',
                'Al-Asr', 'Al-Fiil', 'Al-Quraisy'
            ],
        ];

        $data = [];
        foreach ($materi as $kategori_id => $items) {
            foreach ($items as $nama) {
                $data[] = [
                    'kategori_id' => $kategori_id,
                    'nama' => $nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('materi_penilaian')->insert($data);
    }
}
