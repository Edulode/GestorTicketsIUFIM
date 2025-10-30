<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cambiar el estado "Completado" por "Resuelto"
        DB::table('statuses')
            ->where('status', 'Completado')
            ->update(['status' => 'Resuelto']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el cambio
        DB::table('statuses')
            ->where('status', 'Resuelto')
            ->update(['status' => 'Completado']);
    }
};
