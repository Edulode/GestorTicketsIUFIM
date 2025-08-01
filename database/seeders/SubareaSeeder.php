<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subarea;
use Illuminate\Support\Facades\DB;

class SubareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subareas')->insert([
            ['subarea' => 'Soporte Técnico', 'area_id' => 1],
            ['subarea' => 'Administración de Sistemas', 'area_id' => 2],
            ['subarea' => 'Desarrollo de Software', 'area_id' => 3],
            ['subarea' => 'Redes y Comunicaciones', 'area_id' => 4],
        ]);
    }
}
