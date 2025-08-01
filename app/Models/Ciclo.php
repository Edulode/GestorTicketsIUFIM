<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    protected $fillable = ['ciclo'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
