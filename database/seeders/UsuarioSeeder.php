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
            ['nombre' => 'Juan' , 'apellido_paterno' => 'Pérez', 'apellido_materno' => 'Gómez', 'status' => true],
            ['nombre' => 'María', 'apellido_paterno' => 'López', 'apellido_materno' => 'Hernández', 'status' => true],
            ['nombre' => 'Carlos', 'apellido_paterno' => 'García', 'apellido_materno' => 'Martínez', 'status' => true],
            ['nombre' => 'Ana',   'apellido_paterno' => 'Sánchez', 'apellido_materno' => 'Ramírez', 'status' => true],
            ['nombre' => 'Luis',  'apellido_paterno' => 'Torres', 'apellido_materno' => 'Fernández', 'status' => true],
        ]);
    }
}
