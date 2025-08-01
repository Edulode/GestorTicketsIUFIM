<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use Illuminate\Support\Facades\DB;


class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            ['area' => 'Administración'],
            ['area' => 'Recursos Humanos'],
            ['area' => 'Finanzas'],
            ['area' => 'Marketing'],
        ]);
    }
}
