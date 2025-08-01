<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\TipoSolicitud;

class CategoriaServicio extends Model
{
    protected $fillable = [
        'categoria_servicio',
    ];

    public function tiposSolicitud()
    {
        return $this->hasMany(TipoSolicitud::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
