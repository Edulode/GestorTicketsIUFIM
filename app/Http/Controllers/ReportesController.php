<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Area;
use App\Models\Ciclo;
use App\Models\Status;
use App\Models\Tipo;
use App\Models\TipoSolicitud;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index()
    {
        $ciclos = Ciclo::orderBy('created_at', 'desc')->get();
        $areas = Area::orderBy('area')->get();
        $tipos = Tipo::orderBy('tipo')->get();
        $tiposSolicitud = TipoSolicitud::orderBy('tipo_solicitud')->get();
        
        return view('reportes.index', compact('ciclos', 'areas', 'tipos', 'tiposSolicitud'));
    }

    public function obtenerDatos(Request $request)
    {
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;
        $cicloId = $request->ciclo_id;
        
        // Base query
        $query = Ticket::with(['usuario.area', 'tipo', 'tipoSolicitud', 'status', 'asunto', 'subarea']);
        
        // Aplicar filtros de fecha
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [
                Carbon::parse($fechaInicio)->startOfDay(),
                Carbon::parse($fechaFin)->endOfDay()
            ]);
        }
        
        // Aplicar filtro de ciclo
        if ($cicloId) {
            $query->where('ciclo_id', $cicloId);
        }
        
        $tickets = $query->get();
        
        // Datos para gráficas dinámicas
        $ticketsPorArea = $this->agruparPorArea($tickets);
        $ticketsPorTipo = $this->agruparPorTipo($tickets);
        $ticketsPorLugar = $this->agruparPorLugar($tickets);
        $ticketsPorCategoriaServicio = $this->agruparPorCategoriaServicio($tickets);
        $tiempoResolucion = $this->calcularTiempoResolucion($tickets);
        
        // Datos para gráficas fijas (todos los tickets)
        $todasLasAreas = $this->obtenerAreasMasSolicitan();
        $lugaresMasIncidencias = $this->obtenerLugaresMasIncidencias();
        $incidenciasMasComunes = $this->obtenerIncidenciasMasComunes();
        $listTicketsPendientes = $this->obtenerTicketsPendientes();
        
        // Contar tickets por status
        $ticketsResueltos = $tickets->filter(function($ticket) {
            return $ticket->status && $ticket->status->status === 'Resuelto';
        })->count();
        
        $ticketsPendientesCount = $tickets->filter(function($ticket) {
            return $ticket->status && $ticket->status->status === 'Pendiente';
        })->count();
        
        return response()->json([
            'dinamicas' => [
                'areas' => $ticketsPorArea,
                'tipos' => $ticketsPorTipo,
                'lugares' => $ticketsPorLugar,
                'categorias' => $ticketsPorCategoriaServicio,
                'tiempo_resolucion' => $tiempoResolucion
            ],
            'fijas' => [
                'areas_mas_solicitan' => $todasLasAreas,
                'lugares_mas_incidencias' => $lugaresMasIncidencias,
                'tipos_solicitud_comunes' => $incidenciasMasComunes,
                'tickets_pendientes' => $listTicketsPendientes
            ],
            'estadisticas' => [
                'total_tickets' => $tickets->count(),
                'tickets_completados' => $ticketsResueltos,
                'tickets_pendientes' => $ticketsPendientesCount,
                'tiempo_promedio_resolucion' => $this->calcularTiempoPromedioResolucion($tickets)
            ]
        ]);
    }

    private function agruparPorArea($tickets)
    {
        return $tickets->groupBy(function($ticket) {
            return $ticket->usuario && $ticket->usuario->area ? $ticket->usuario->area->area : 'Sin área';
        })->map(function($group) {
            return $group->count();
        })->toArray();
    }

    private function agruparPorTipo($tickets)
    {
        // Filtrar solo tickets que tienen tipo de solicitud asignado
        $ticketsConTipo = $tickets->filter(function($ticket) {
            return $ticket->tipoSolicitud && 
                   $ticket->tipoSolicitud->tipo_solicitud &&
                   !empty(trim($ticket->tipoSolicitud->tipo_solicitud));
        });

        if ($ticketsConTipo->isEmpty()) {
            return [];
        }

        $tiposSolicitud = $ticketsConTipo->groupBy(function($ticket) {
            return trim($ticket->tipoSolicitud->tipo_solicitud);
        })->map(function($group) {
            return $group->count();
        });
        
        // Ordenar por cantidad descendente y tomar solo los top 5
        return $tiposSolicitud->sortDesc()->take(5)->toArray();
    }

    private function agruparPorLugar($tickets)
    {
        $lugares = $tickets->groupBy(function($ticket) {
            return $ticket->subarea && $ticket->subarea->subarea ? $ticket->subarea->subarea : 'Sin lugar especificado';
        })->map(function($group) {
            return $group->count();
        });
        
        // Ordenar por cantidad descendente y tomar solo los top 7
        return $lugares->sortDesc()->take(7)->toArray();
    }

    private function agruparPorCategoriaServicio($tickets)
    {
        // Filtrar solo tickets que:
        // 1. Están completados/resueltos
        // 2. Tienen categoría de servicio asignada (no null ni vacía)
        // 3. La categoría no contiene palabras como "sin" o "no especificada"
        $ticketsValidos = $tickets->filter(function($ticket) {
            if (!$ticket->status || $ticket->status->status !== 'Resuelto') {
                return false;
            }
            
            if (!$ticket->categoriaServicio || !$ticket->categoriaServicio->categoria_servicio) {
                return false;
            }
            
            $categoria = strtolower(trim($ticket->categoriaServicio->categoria_servicio));
            
            // Excluir categorías que contengan estas palabras
            $palabrasExcluidas = ['sin ', 'no especifica', 'no asignada', 'sin tipo', 'null', 'ninguna', 'vacío'];
            
            foreach ($palabrasExcluidas as $palabra) {
                if (strpos($categoria, $palabra) !== false) {
                    return false;
                }
            }
            
            return !empty($categoria);
        });

        if ($ticketsValidos->isEmpty()) {
            return [];
        }

        $categorias = $ticketsValidos->groupBy(function($ticket) {
            return trim($ticket->categoriaServicio->categoria_servicio);
        })->map(function($group) {
            return $group->count();
        });
        
        // Ordenar por cantidad descendente y tomar solo los top 5
        return $categorias->sortDesc()->take(5)->toArray();
    }

    private function calcularTiempoResolucion($tickets)
    {
        $resueltos = $tickets->filter(function($ticket) {
            return $ticket->status && $ticket->status->status === 'Resuelto' && $ticket->fecha_atencion;
        });

        return $resueltos->map(function($ticket) {
            $inicio = Carbon::parse($ticket->created_at);
            $fin = Carbon::parse($ticket->fecha_atencion);
            return [
                'ticket_id' => $ticket->id,
                'dias' => $inicio->diffInDays($fin),
                'horas' => $inicio->diffInHours($fin)
            ];
        })->values()->toArray();
    }

    private function calcularTiempoPromedioResolucion($tickets)
    {
        $resueltos = $tickets->filter(function($ticket) {
            return $ticket->status && $ticket->status->status === 'Resuelto' && $ticket->fecha_atencion;
        });

        if ($resueltos->count() === 0) {
            return 0;
        }

        $totalHoras = $resueltos->sum(function($ticket) {
            $inicio = Carbon::parse($ticket->created_at);
            $fin = Carbon::parse($ticket->fecha_atencion);
            return $inicio->diffInHours($fin);
        });

        return round($totalHoras / $resueltos->count(), 2);
    }

    private function obtenerAreasMasSolicitan()
    {
        return DB::table('tickets')
                ->join('usuarios', 'tickets.usuario_id', '=', 'usuarios.id')
                ->join('areas', 'usuarios.area_id', '=', 'areas.id')
                ->select('areas.area', DB::raw('count(*) as total'))
                ->groupBy('areas.id', 'areas.area')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->pluck('total', 'area')
                ->toArray();
    }

    private function obtenerLugaresMasIncidencias()
    {
        return DB::table('tickets')
                ->join('subareas', 'tickets.subarea_id', '=', 'subareas.id')
                ->select('subareas.subarea', DB::raw('count(*) as total'))
                ->groupBy('subareas.id', 'subareas.subarea')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->pluck('total', 'subarea')
                ->toArray();
    }

    private function obtenerIncidenciasMasComunes()
    {
        return DB::table('tickets')
                ->join('tipo_solicituds', 'tickets.tipo_solicitud_id', '=', 'tipo_solicituds.id')
                ->select('tipo_solicituds.tipo_solicitud', DB::raw('count(*) as total'))
                ->groupBy('tipo_solicituds.id', 'tipo_solicituds.tipo_solicitud')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->pluck('total', 'tipo_solicitud')
                ->toArray();
    }

    private function obtenerTicketsPendientes()
    {
        return DB::table('tickets')
                ->join('usuarios', 'tickets.usuario_id', '=', 'usuarios.id')
                ->join('areas', 'usuarios.area_id', '=', 'areas.id')
                ->join('statuses', 'tickets.status_id', '=', 'statuses.id')
                ->leftJoin('asuntos', 'tickets.asunto_id', '=', 'asuntos.id')
                ->select(
                    'tickets.id',
                    'asuntos.asunto',
                    'areas.area',
                    'statuses.status',
                    'tickets.created_at'
                )
                ->where('statuses.status', 'Pendiente')
                ->orderBy('tickets.created_at', 'asc')
                ->get()
                ->map(function($ticket) {
                    return [
                        'id' => $ticket->id,
                        'asunto' => $ticket->asunto ?? 'Sin asunto',
                        'area' => $ticket->area ?? 'Sin área',
                        'status' => $ticket->status ?? 'Sin estado',
                        'fecha_creacion' => Carbon::parse($ticket->created_at)->format('d/m/Y H:i'),
                        'dias_pendiente' => Carbon::parse($ticket->created_at)->diffInDays(now())
                    ];
                })
                ->toArray();
    }

    public function exportar(Request $request)
    {
        // Aquí puedes implementar la exportación a PDF o Excel
        // Por ahora retornamos los datos en JSON
        return $this->obtenerDatos($request);
    }
}
