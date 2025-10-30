<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Area;
use App\Models\Asunto;
use App\Models\CategoriaServicio;
use App\Models\Ciclo;
use App\Models\Status;
use App\Models\Subarea;
use App\Models\Tecnico;
use App\Models\Ticket;
use App\Models\Tipo;
use App\Models\TipoSolicitud;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CicloSeeder::class,
            CategoriaServicioSeeder::class,
            AreaSeeder::class,
            SubareaSeeder::class,
            TipoSeeder::class,
            TipoSolicitudSeeder::class,
            AsuntoSeeder::class,
            StatusSeeder::class,
            TecnicoSeeder::class,
            UsuarioSeeder::class,
            UserSeeder::class,
        ]);
    }
}
