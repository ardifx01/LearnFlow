<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AppSettingsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(WaliKelasSeeder::class);
        $this->call(KelasSeeder::class);
        // $this->call(KategoriPenilaianSeeder::class);
        // $this->call(MateriPenilaianSeeder::class);

    }
}
