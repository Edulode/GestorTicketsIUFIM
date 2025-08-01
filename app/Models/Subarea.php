<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\Area;

class Subarea extends Model
{
    protected $fillable = ['subarea', 'area_id'];
    
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
