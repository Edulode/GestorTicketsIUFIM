<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;

class CheckUsuariosAreas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:usuarios-areas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar usuarios y sus áreas asignadas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📋 Verificando usuarios y sus áreas asignadas...');
        $this->newLine();

        $usuarios = Usuario::with('area')->get();

        $tableData = [];
        foreach ($usuarios as $usuario) {
            $areaInfo = $usuario->area ? $usuario->area->nombre : '❌ Sin área';
            $tableData[] = [
                $usuario->id,
                $usuario->nombre,
                $areaInfo,
                $usuario->area_id ?? 'NULL'
            ];
        }

        $this->table([
            'ID',
            'Usuario',
            'Área',
            'Area ID'
        ], $tableData);

        // Mostrar también las áreas disponibles
        $this->newLine();
        $this->info('🏢 Áreas disponibles:');
        $areas = \App\Models\Area::all();
        foreach ($areas as $area) {
            $this->line("   • ID: {$area->id} - {$area->nombre}");
        }

        $sinArea = $usuarios->filter(function($u) { return !$u->area_id; });
        
        if ($sinArea->count() > 0) {
            $this->newLine();
            $this->warn("⚠️  {$sinArea->count()} usuarios sin área asignada:");
            foreach ($sinArea as $usuario) {
                $this->line("   • {$usuario->nombre}");
            }
        } else {
            $this->newLine();
            $this->info('✅ Todos los usuarios tienen área asignada');
        }

        return Command::SUCCESS;
    }
}
