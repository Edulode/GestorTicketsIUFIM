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
            ['subarea' => 'Clínica 1', 'area_id' => 1],
            ['subarea' => 'Prepa ', 'area_id' => 2],
            ['subarea' => 'Direccción', 'area_id' => 3],
            ['subarea' => 'Bilbioteca', 'area_id' => 4],
        ]);
    }
}
