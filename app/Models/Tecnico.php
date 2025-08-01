<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnico;
use App\Models\Ticket;

class Tecnico extends Model
{
    protected $fillable = ['nombre', 'apellidoP', 'apellidoM', 'status'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
