<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tecnico;
use Illuminate\Support\Facades\DB;

class TecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tecnicos')->insert([
            ['nombre' => 'Eduardo', 'apellidoP' => 'Lopez', 'apellidoM' => 'Delgado'],
            ['nombre' => 'Maria', 'apellidoP' => 'Gomez', 'apellidoM' => 'Perez'],
            ['nombre' => 'Juan', 'apellidoP' => 'Martinez', 'apellidoM' => 'Sanchez'],
            ['nombre' => 'Ana', 'apellidoP' => 'Torres', 'apellidoM' => 'Ramirez'],
        ]);
    }
}
