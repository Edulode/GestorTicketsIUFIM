<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            ['nombre' => 'Juan' , 'apellido_paterno' => 'Pérez', 'apellido_materno' => 'Gómez', 'area_id' => 1, 'status' => true],
            ['nombre' => 'María', 'apellido_paterno' => 'López', 'apellido_materno' => 'Hernández', 'area_id' => 2, 'status' => true],
            ['nombre' => 'Carlos', 'apellido_paterno' => 'García', 'apellido_materno' => 'Martínez', 'area_id' => 4, 'status' => true],
            ['nombre' => 'Ana',   'apellido_paterno' => 'Sánchez', 'apellido_materno' => 'Ramírez', 'area_id' => 3, 'status' => true],
            ['nombre' => 'Luis',  'apellido_paterno' => 'Torres', 'apellido_materno' => 'Fernández', 'area_id' => 2, 'status' => true],
        ]);
    }
}
