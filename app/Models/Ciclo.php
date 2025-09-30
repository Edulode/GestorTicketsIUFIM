<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ciclo extends Model
{
    protected $fillable = ['ciclo'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Obtiene el ciclo actual basado en la fecha
     * Los cuatrimestres se dividen así:
     * - Enero-Abril: A
     * - Mayo-Agosto: B  
     * - Septiembre-Diciembre: C
     */
    public static function getCurrentCiclo()
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        
        if ($month >= 1 && $month <= 4) {
            $cuatrimestre = 'A';
        } elseif ($month >= 5 && $month <= 8) {
            $cuatrimestre = 'B';
        } else {
            $cuatrimestre = 'C';
        }
        
        $cicloNombre = $year . $cuatrimestre;
        
        // Buscar o crear el ciclo
        return self::firstOrCreate(['ciclo' => $cicloNombre]);
    }
}
