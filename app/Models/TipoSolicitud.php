<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\CategoriaServicio;

class TipoSolicitud extends Model
{
    protected $fillable = [
        'tipo_solicitud',
        'categoria_servicio_id',
    ];

    public function categoriaServicio()
    {
        return $this->belongsTo(CategoriaServicio::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}