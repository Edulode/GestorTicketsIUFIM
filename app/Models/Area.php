<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subarea;
use App\Models\Ticket;
use App\Models\Usuario;

class Area extends Model
{
    protected $fillable = ['area'];
    
    // Accessor para que funcione tanto con 'area' como con 'nombre'
    public function getNombreAttribute()
    {
        return $this->area;
    }
    
    public function subareas()
    {
        return $this->hasMany(Subarea::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
}
