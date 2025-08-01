<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ciclo;
use App\Models\Area;
use App\Models\Subarea;
use App\Models\Usuario;
use App\Models\TipoSolicitud;
use App\Models\Tipo;
use App\Models\Asunto;
use App\Models\CategoriaServicio;
use App\Models\Status;
use App\Models\Tecnico;

class Ticket extends Model
{
    protected $fillable = [
    'ciclo_id', 'tipo_id', 'fecha', 'area_id', 'usuario_id', 'solicitud',
    'subarea_id', 'asunto_id', 'tipo_solicitud_id', 'categoria_servicio_id',
    'status_id', 'tecnico_id', 'incidencia_real', 'servicio_realizado',
    'fecha_atencion', 'notas', 'observaciones'
    ];

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
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
