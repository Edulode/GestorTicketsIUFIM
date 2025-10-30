<?php

namespace App\Helpers;

use Carbon\Carbon;

class CicloHelper
{
    /**
     * Obtiene el ciclo actual basado en la fecha
     *
     * @param Carbon|null $fecha
     * @return string
     */
    public static function getCicloActual($fecha = null)
    {
        $fecha = $fecha ?: Carbon::now();
        $year = $fecha->year;
        
        // Si es antes del 30 de junio (mes 6, día 30)
        if ($fecha->month < 6 || ($fecha->month == 6 && $fecha->day <= 30)) {
            return $year . 'B';
        } else {
            return $year . 'A';
        }
    }
    
    /**
     * Obtiene información detallada del ciclo actual
     *
     * @param Carbon|null $fecha
     * @return array
     */
    public static function getInfoCicloActual($fecha = null)
    {
        $fecha = $fecha ?: Carbon::now();
        $ciclo = self::getCicloActual($fecha);
        $year = $fecha->year;
        
        $esPrimerSemestre = $fecha->month < 6 || ($fecha->month == 6 && $fecha->day <= 30);
        
        if ($esPrimerSemestre) {
            $periodo = 'Enero - Junio';
            $fechaInicio = Carbon::create($year, 1, 1);
            $fechaFin = Carbon::create($year, 6, 30);
            $nombre = "Primer Semestre $year";
        } else {
            $periodo = 'Julio - Diciembre';
            $fechaInicio = Carbon::create($year, 7, 1);
            $fechaFin = Carbon::create($year, 12, 31);
            $nombre = "Segundo Semestre $year";
        }
        
        return [
            'codigo' => $ciclo,
            'nombre' => $nombre,
            'periodo' => $periodo,
            'year' => $year,
            'semestre' => $esPrimerSemestre ? 1 : 2,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'es_primer_semestre' => $esPrimerSemestre,
            'dias_restantes' => $fechaFin->diffInDays($fecha),
            'progreso_porcentaje' => $fechaInicio->diffInDays($fecha) / $fechaInicio->diffInDays($fechaFin) * 100
        ];
    }
    
    /**
     * Obtiene todos los ciclos disponibles (últimos 5 años + próximo año)
     *
     * @return array
     */
    public static function getTodosCiclos()
    {
        $ciclos = [];
        $yearActual = Carbon::now()->year;
        
        // Últimos 5 años + año actual + próximo año
        for ($year = $yearActual - 5; $year <= $yearActual + 1; $year++) {
            $ciclos[] = [
                'codigo' => $year . 'A',
                'nombre' => "Segundo Semestre $year",
                'periodo' => 'Julio - Diciembre',
                'year' => $year
            ];
            $ciclos[] = [
                'codigo' => $year . 'B',
                'nombre' => "Primer Semestre $year",
                'periodo' => 'Enero - Junio',
                'year' => $year
            ];
        }
        
        // Ordenar por año y semestre (B primero, luego A)
        usort($ciclos, function($a, $b) {
            if ($a['year'] == $b['year']) {
                return strcmp($a['codigo'], $b['codigo']); // B viene antes que A
            }
            return $b['year'] - $a['year']; // Años más recientes primero
        });
        
        return $ciclos;
    }
    
    /**
     * Obtiene el ciclo de una fecha específica
     *
     * @param string $fecha
     * @return string
     */
    public static function getCicloDeFecha($fecha)
    {
        return self::getCicloActual(Carbon::parse($fecha));
    }
    
    /**
     * Verifica si un código de ciclo es válido
     *
     * @param string $codigo
     * @return bool
     */
    public static function esCodigoValido($codigo)
    {
        return preg_match('/^\d{4}[AB]$/', $codigo);
    }
    
    /**
     * Obtiene información de un ciclo por su código
     *
     * @param string $codigo
     * @return array|null
     */
    public static function getInfoPorCodigo($codigo)
    {
        if (!self::esCodigoValido($codigo)) {
            return null;
        }
        
        $year = intval(substr($codigo, 0, 4));
        $semestre = substr($codigo, 4, 1);
        
        if ($semestre === 'B') {
            return [
                'codigo' => $codigo,
                'nombre' => "Primer Semestre $year",
                'periodo' => 'Enero - Junio',
                'year' => $year,
                'semestre' => 1,
                'fecha_inicio' => Carbon::create($year, 1, 1),
                'fecha_fin' => Carbon::create($year, 6, 30),
                'es_primer_semestre' => true
            ];
        } else {
            return [
                'codigo' => $codigo,
                'nombre' => "Segundo Semestre $year",
                'periodo' => 'Julio - Diciembre',
                'year' => $year,
                'semestre' => 2,
                'fecha_inicio' => Carbon::create($year, 7, 1),
                'fecha_fin' => Carbon::create($year, 12, 31),
                'es_primer_semestre' => false
            ];
        }
    }
}