<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\Usuario;

class Area extends Model
{
    protected $fillable = ['area'];
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
}
