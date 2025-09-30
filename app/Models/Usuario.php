<?php

namespace App\Models;

use App\Models\Ticket;
use App\Models\Area;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'area_id',
        'status',
    ];
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
