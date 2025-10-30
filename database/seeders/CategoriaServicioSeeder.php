<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoriaServicio;
use Illuminate\Support\Facades\DB;


class CategoriaServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categoria_servicios')->insert([
            ['categoria_servicio' => 'Acceso a sistemas'],
            ['categoria_servicio' => 'Apoyo en eventos de otras áreas'],
            ['categoria_servicio' => 'Asesorías'],
            ['categoria_servicio' => 'Aulas'],
            ['categoria_servicio' => 'Cableado de red'],
            ['categoria_servicio' => 'Certificaciones'],
            ['categoria_servicio' => 'Consumibles-tintas'],
            ['categoria_servicio' => 'Correo institucional'],
            ['categoria_servicio' => 'Eléctrico'],
            ['categoria_servicio' => 'Hardware'],
            ['categoria_servicio' => 'Información para otras areas'],
            ['categoria_servicio' => 'Internet'],
            ['categoria_servicio' => 'Proveedor'],
            ['categoria_servicio' => 'Red'],
            ['categoria_servicio' => 'Salas de cómputo'],
            ['categoria_servicio' => 'Servicios genéricos'],
            ['categoria_servicio' => 'Sistemas-funcionamiento'],
            ['categoria_servicio' => 'Software'],
            ['categoria_servicio' => 'Telefonía'],
        ]);
    }
}
