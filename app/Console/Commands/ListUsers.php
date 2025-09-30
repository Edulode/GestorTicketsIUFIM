<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listar todos los usuarios del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('👥 Usuarios del Sistema de Tickets');
        $this->newLine();

        $users = User::orderBy('created_at', 'desc')->get();

        if ($users->count() === 0) {
            $this->warn('❌ No hay usuarios registrados en el sistema.');
            $this->newLine();
            $this->comment('💡 Usa el comando "php artisan user:create" para crear un nuevo usuario.');
            return Command::SUCCESS;
        }

        $tableData = $users->map(function ($user) {
            return [
                $user->id,
                $user->name,
                $user->email,
                $user->email_verified_at ? '✅ Verificado' : '❌ No verificado',
                $user->created_at->format('d/m/Y H:i'),
            ];
        })->toArray();

        $this->table([
            'ID',
            'Nombre',
            'Email',
            'Estado',
            'Fecha de Creación'
        ], $tableData);

        $this->newLine();
        $this->info("📊 Total de usuarios: {$users->count()}");
        
        return Command::SUCCESS;
    }
}
