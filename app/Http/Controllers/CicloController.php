<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CicloHelper;
use App\Models\Ticket;
use Carbon\Carbon;

class CicloController extends Controller
{
    /**
     * Muestra información sobre el sistema de ciclos automáticos
     */
    public function index(Request $request)
    {
        $cicloActual = CicloHelper::getInfoCicloActual();
        $todosCiclos = CicloHelper::getTodosCiclos();
        
        // Obtener estadísticas de tickets por ciclo
        $estadisticasCiclos = [];
        foreach ($todosCiclos as $ciclo) {
            $ticketsCount = Ticket::where('ciclo', $ciclo['codigo'])->count();
            $estadisticasCiclos[$ciclo['codigo']] = $ticketsCount;
        }
        
        // Filtros
        $filtroAnio = $request->get('year', $cicloActual['year']);
        $ciclosFiltrados = array_filter($todosCiclos, function($ciclo) use ($filtroAnio) {
            return $ciclo['year'] == $filtroAnio;
        });
        
        return view('ciclos.index', compact('cicloActual', 'todosCiclos', 'ciclosFiltrados', 'estadisticasCiclos', 'filtroAnio'));
    }

    /**
     * Muestra información detallada de un ciclo específico
     */
    public function show($codigo)
    {
        if (!CicloHelper::esCodigoValido($codigo)) {
            abort(404, 'Ciclo no válido');
        }
        
        $ciclo = CicloHelper::getInfoPorCodigo($codigo);
        $cicloActual = CicloHelper::getInfoCicloActual();
        
        // Obtener tickets de este ciclo
        $tickets = Ticket::where('ciclo', $codigo)
            ->with(['status', 'area', 'usuario', 'tecnico'])
            ->orderBy('fecha', 'desc')
            ->paginate(10);
        
        // Estadísticas del ciclo
        $estadisticas = [
            'total_tickets' => Ticket::where('ciclo', $codigo)->count(),
            'tickets_abiertos' => Ticket::where('ciclo', $codigo)->whereHas('status', function($q) {
                $q->where('status', 'Abierto');
            })->count(),
            'tickets_proceso' => Ticket::where('ciclo', $codigo)->whereHas('status', function($q) {
                $q->where('status', 'En Proceso');
            })->count(),
            'tickets_cerrados' => Ticket::where('ciclo', $codigo)->whereHas('status', function($q) {
                $q->where('status', 'Cerrado');
            })->count(),
        ];
        
        return view('ciclos.show', compact('ciclo', 'cicloActual', 'tickets', 'estadisticas'));
    }

    /**
     * API: Obtiene el ciclo actual
     */
    public function getCicloActual()
    {
        return response()->json(CicloHelper::getInfoCicloActual());
    }

    /**
     * API: Obtiene todos los ciclos disponibles
     */
    public function getTodosCiclos()
    {
        return response()->json(CicloHelper::getTodosCiclos());
    }
}
