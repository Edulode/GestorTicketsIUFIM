<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;


class Asunto extends Model
{
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
