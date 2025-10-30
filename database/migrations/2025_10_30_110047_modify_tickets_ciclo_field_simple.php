<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\CicloHelper;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Intentar eliminar el constraint si existe
        try {
            \DB::statement('ALTER TABLE tickets DROP FOREIGN KEY tickets_ciclo_id_foreign');
        } catch (\Exception $e) {
            // Si no existe, continuar
        }
        
        // Agregar la nueva columna ciclo
        if (!Schema::hasColumn('tickets', 'ciclo')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->string('ciclo', 10)->after('id');
            });
        }
        
        // Actualizar los registros existentes si hay datos
        $tickets = \DB::table('tickets')->get();
        if ($tickets->count() > 0) {
            foreach ($tickets as $ticket) {
                $ciclo = CicloHelper::getCicloDeFecha($ticket->fecha);
                \DB::table('tickets')
                    ->where('id', $ticket->id)
                    ->update(['ciclo' => $ciclo]);
            }
        }
        
        // Eliminar la columna ciclo_id si existe
        if (Schema::hasColumn('tickets', 'ciclo_id')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn('ciclo_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'ciclo_id')) {
                $table->unsignedBigInteger('ciclo_id')->after('id');
            }
            
            if (Schema::hasColumn('tickets', 'ciclo')) {
                $table->dropColumn('ciclo');
            }
        });
    }
};
