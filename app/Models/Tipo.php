<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
