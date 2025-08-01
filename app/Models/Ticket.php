<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
    'ciclo_id', 'tipo_id', 'fecha', 'area_id', 'usuario_id', 'solicitud',
    'subarea_id', 'asunto_id', 'tipo_solicitud_id', 'categoria_servicio_id',
    'status_id', 'tecnico_id', 'incidencia_real', 'servicio_realizado',
    'fecha_atencion', 'notas', 'observaciones'
];

}
