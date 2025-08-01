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
            ['categoria_servicio' => 'Soporte Técnico'],
            ['categoria_servicio' => 'Mantenimiento'],
            ['categoria_servicio' => 'Consultoría'],
            ['categoria_servicio' => 'Desarrollo de Software'],
        ]);
    }
}
