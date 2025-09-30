<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ciclo_id')->constrained('ciclos');
            $table->foreignId('tipo_id')->constrained('tipos');
            $table->timestamp('fecha');
            $table->foreignId('area_id')->constrained('areas');
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->text('solicitud');
            $table->foreignId('subarea_id')->constrained('subareas');
            $table->foreignId('asunto_id')->constrained('asuntos');
            $table->foreignId('tipo_solicitud_id')->nullable()->constrained('tipo_solicituds');
            $table->foreignId('categoria_servicio_id')->nullable()->constrained('categoria_servicios');
            $table->foreignId('status_id')->default(1)->constrained('statuses');
            $table->foreignId('tecnico_id')->nullable()->constrained('tecnicos');
            $table->text('incidencia_real')->nullable();
            $table->text('servicio_realizado')->nullable();
            $table->timestamp('fecha_atencion')->nullable();
            $table->text('notas')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
