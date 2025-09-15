<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('app_settings')->insert([
            'app_name' => 'Learn Flow',
            'app_logo' => null,
            'show_logo' => 1,
            'show_name' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
