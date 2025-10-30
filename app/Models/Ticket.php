<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Subarea;
use App\Models\Usuario;
use App\Models\TipoSolicitud;
use App\Models\Tipo;
use App\Models\Asunto;
use App\Models\CategoriaServicio;
use App\Models\Status;
use App\Models\Tecnico;
use App\Helpers\CicloHelper;

class Ticket extends Model
{
    protected $fillable = [
        'ciclo', 'tipo_id', 'fecha', 'area_id', 'usuario_id', 'solicitud',
        'subarea_id', 'asunto_id', 'tipo_solicitud_id', 'categoria_servicio_id',
        'status_id', 'tecnico_id', 'incidencia_real', 'servicio_realizado',
        'fecha_atencion', 'notas', 'observaciones'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'fecha_atencion' => 'datetime',
    ];

    /**
     * Boot del modelo para asignar automáticamente el ciclo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ciclo)) {
                $ticket->ciclo = CicloHelper::getCicloActual($ticket->fecha);
            }
        });
    }

    /**
     * Obtiene la información del ciclo
     */
    public function getCicloInfoAttribute()
    {
        return CicloHelper::getInfoPorCodigo($this->ciclo);
    }

    /**
     * Obtiene el nombre completo del ciclo
     */
    public function getCicloNombreAttribute()
    {
        $info = $this->ciclo_info;
        return $info ? $info['nombre'] : $this->ciclo;
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function subarea()
    {
        return $this->belongsTo(Subarea::class);
    }

    public function asunto()
    {
        return $this->belongsTo(Asunto::class);
    }

    public function tipoSolicitud()
    {
        return $this->belongsTo(TipoSolicitud::class);
    }

    public function categoriaServicio()
    {
        return $this->belongsTo(CategoriaServicio::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }
}
