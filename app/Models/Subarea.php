<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;

class Subarea extends Model
{
    protected $fillable = ['subarea'];
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
