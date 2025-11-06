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
        $tecnicos = [
            ['nombre' => 'Jennifer', 'apellidoP' => ' ', 'apellidoM' => ' '],
            ['nombre' => 'Nora', 'apellidoP' => ' ', 'apellidoM' => ' '],
            ['nombre' => 'Tomás', 'apellidoP' => ' ', 'apellidoM' => ' '],
            ['nombre' => 'Juan', 'apellidoP' => ' ', 'apellidoM' => ' '],
            ['nombre' => 'Tomás', 'apellidoP' => 'y', 'apellidoM' => 'Juan'],
            ['nombre' => 'Jennifer', 'apellidoP' => 'y', 'apellidoM' => 'Tomás'],
            ['nombre' => 'Jennifer', 'apellidoP' => 'y', 'apellidoM' => 'Juan'],
            ['nombre' => 'Rafael', 'apellidoP' => ' ', 'apellidoM' => ' '],
            ['nombre' => 'Adrián', 'apellidoP' => 'Salvador ', 'apellidoM' => ' '],
        ];

        foreach ($tecnicos as $tecnicoData) {
            Tecnico::create([
                'nombre' => $tecnicoData['nombre'],
                'apellidoP' => $tecnicoData['apellidoP'],
                'apellidoM' => $tecnicoData['apellidoM'],
                'status' => true
            ]);
        }
    }
}
