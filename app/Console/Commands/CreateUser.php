<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear un nuevo usuario para el sistema de tickets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎫 Creando nuevo usuario para el Sistema de Tickets');
        $this->newLine();

        // Obtener datos del usuario
        $name = $this->option('name') ?: $this->ask('Nombre completo del usuario');
        $email = $this->option('email') ?: $this->ask('Email del usuario');
        $password = $this->option('password') ?: $this->secret('Contraseña del usuario');

        // Validar los datos
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $this->error('❌ Error en la validación:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("   • $error");
            }
            return Command::FAILURE;
        }

        try {
            // Crear el usuario
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $this->newLine();
            $this->info('✅ Usuario creado exitosamente!');
            $this->newLine();
            
            $this->table(['Campo', 'Valor'], [
                ['ID', $user->id],
                ['Nombre', $user->name],
                ['Email', $user->email],
                ['Fecha de creación', $user->created_at->format('d/m/Y H:i:s')],
            ]);

            $this->newLine();
            $this->info('🔑 Credenciales de acceso:');
            $this->info("   Email: {$email}");
            $this->info("   Contraseña: {$password}");
            $this->newLine();
            $this->comment('💡 El usuario puede iniciar sesión inmediatamente.');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error al crear el usuario: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
