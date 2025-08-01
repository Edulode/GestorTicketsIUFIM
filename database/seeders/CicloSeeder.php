<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ciclo;
use Illuminate\Support\Facades\DB;


class CicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ciclos')->insert([
            ['ciclo' => '2025A'],
            ['ciclo' => '2025B'],
            ['ciclo' => '2025C'],
        ]);
    }
}
