<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoSolicitud;
use Illuminate\Support\Facades\DB;

class TipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_solicituds')->insert([
            ['tipo_solicitud' => 'Solicitud de Soporte', 'categoria_servicio_id' => 1],
            ['tipo_solicitud' => 'Solicitud de Mantenimiento', 'categoria_servicio_id' => 2],
            ['tipo_solicitud' => 'Solicitud de Consultoría', 'categoria_servicio_id' => 3],
            ['tipo_solicitud' => 'Solicitud de Desarrollo', 'categoria_servicio_id' => 4],
        ]);
    }
}
