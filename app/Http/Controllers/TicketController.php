<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\Ciclo;
use App\Models\Area;
use App\Models\Subarea;
use App\Models\Usuario;
use App\Models\TipoSolicitud;
use App\Models\Tipo;
use App\Models\Asunto;
use App\Models\CategoriaServicio;
use App\Models\Status;
use App\Models\Tecnico;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['area', 'usuario', 'status']);
        
        // Filtro por estado
        if ($request->filled('status')) {
            $query->whereHas('status', function($q) use ($request) {
                $q->where('status', 'like', '%' . $request->status . '%');
            });
        }
        
        // Filtro por área
        if ($request->filled('area')) {
            $query->where('area_id', $request->area);
        }
        
        // Filtro por fecha
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        
        // Filtro por búsqueda (solicitud, usuario, área)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('solicitud', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('usuario', function($subQ) use ($searchTerm) {
                      $subQ->where('nombre', 'like', '%' . $searchTerm . '%')
                           ->orWhere('apellido_paterno', 'like', '%' . $searchTerm . '%')
                           ->orWhere('apellido_materno', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('area', function($subQ) use ($searchTerm) {
                      $subQ->where('area', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // Ordenar por fecha de creación (más recientes primero)
        $tickets = $query->orderBy('created_at', 'desc')->get();
        
        // Cargar todas las áreas para el filtro
        $areas = \App\Models\Area::all();
        
        return view('tickets.index', compact('tickets', 'areas'));
    }

    /**
     * Get tickets via AJAX for real-time updates
     */
    public function getTicketsAjax(Request $request)
    {
        $query = Ticket::with(['area', 'usuario', 'status']);
        
        // Aplicar los mismos filtros que en index()
        if ($request->filled('status')) {
            $query->whereHas('status', function($q) use ($request) {
                $q->where('status', 'like', '%' . $request->status . '%');
            });
        }
        
        if ($request->filled('area')) {
            $query->where('area_id', $request->area);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('solicitud', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('usuario', function($subQ) use ($searchTerm) {
                      $subQ->where('nombre', 'like', '%' . $searchTerm . '%')
                           ->orWhere('apellido_paterno', 'like', '%' . $searchTerm . '%')
                           ->orWhere('apellido_materno', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('area', function($subQ) use ($searchTerm) {
                      $subQ->where('area', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        $tickets = $query->orderBy('created_at', 'desc')->get();
        
        // Formatear los datos para la respuesta JSON
        $formattedTickets = $tickets->map(function($ticket) {
            return [
                'id' => $ticket->id,
                'solicitud' => $ticket->solicitud,
                'area_nombre' => $ticket->area ? $ticket->area->area : 'Sin área',
                'usuario_nombre' => $ticket->usuario ? 
                    $ticket->usuario->nombre . ' ' . $ticket->usuario->apellido_paterno . ' ' . $ticket->usuario->apellido_materno 
                    : 'Sin usuario',
                'fecha' => $ticket->created_at->format('d/m/Y'),
                'hora' => $ticket->created_at->format('H:i'),
                'status' => $ticket->status ? $ticket->status->status : 'Sin Estado',
                'status_color' => $this->getStatusColor($ticket->status ? $ticket->status->status : 'Sin Estado'),
                'show_url' => route('tickets.show', $ticket->id),
                'edit_url' => route('tickets.edit', $ticket->id)
            ];
        });
        
        return response()->json([
            'tickets' => $formattedTickets,
            'total' => $tickets->count(),
            'pendientes' => $tickets->filter(function($ticket) { 
                return $ticket->status && $ticket->status->status === 'Pendiente'; 
            })->count(),
            'completados' => $tickets->filter(function($ticket) { 
                return $ticket->status && $ticket->status->status === 'Resuelto'; 
            })->count()
        ]);
    }
    
    /**
     * Helper method to get status colors
     */
    private function getStatusColor($status)
    {
        $statusColors = [
            'Pendiente' => 'bg-yellow-100 text-yellow-800',
            'Resuelto' => 'bg-green-100 text-green-800'
        ];
        return $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
    }

    public function create()
    {
        try {
            // Solo cargar los datos necesarios para el formulario simplificado
            $areas = Area::all();
            $usuarios = Usuario::with('area')->get(); // Cargar usuarios con sus áreas
            $subareas = Subarea::all();
            
            // Obtener el ciclo actual para mostrarlo en la vista
            $cicloActual = Ciclo::getCurrentCiclo();

            return view('tickets.create', compact('areas', 'usuarios', 'subareas', 'cicloActual'));
        } catch (\Exception $e) {
            \Log::error('Error en create method: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar los campos requeridos
            $request->validate([
                'usuario_id' => 'required|exists:usuarios,id',
                'area_id' => 'required|exists:areas,id',
                'subarea_id' => 'required|exists:subareas,id',
                'solicitud' => 'required|string|min:1|max:1000',
            ]);

            // Obtener el ciclo actual automáticamente
            $cicloActual = Ciclo::getCurrentCiclo();
            
            // Obtener valores por defecto
            $tipoGeneral = Tipo::first(); // Usar el primer tipo como defecto
            $asuntoGeneral = Asunto::first(); // Usar el primer asunto como defecto
            $tipoSolicitudGeneral = TipoSolicitud::first(); // Usar el primer tipo de solicitud como defecto
            $statusPendiente = Status::where('status', 'Pendiente')->first() ?? Status::first();

            $ticket = Ticket::create([
                'ciclo_id' => $cicloActual->id,
                'tipo_id' => $tipoGeneral ? $tipoGeneral->id : 1,
                'fecha' => now()->toDateString(), // Fecha actual
                'area_id' => $request->area_id,
                'usuario_id' => $request->usuario_id,
                'solicitud' => $request->solicitud,
                'subarea_id' => $request->subarea_id,
                'asunto_id' => $asuntoGeneral ? $asuntoGeneral->id : 1,
                'tipo_solicitud_id' => $tipoSolicitudGeneral ? $tipoSolicitudGeneral->id : 1,
                'categoria_servicio_id' => null,
                'status_id' => $statusPendiente ? $statusPendiente->id : 1,
                'tecnico_id' => null,
                'incidencia_real' => null,
                'servicio_realizado' => null,
                'fecha_atencion' => null,
                'notas' => $request->notas,
                'observaciones' => null,
            ]);
            
            return redirect()->route('tickets.create')->with('success', 'Ticket creado exitosamente. Se asignó automáticamente al ciclo ' . $cicloActual->ciclo . '. ID del ticket: #' . $ticket->id);
        } catch (\Exception $e) {
            \Log::error('Error al crear ticket: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear el ticket: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $ticket = Ticket::with(['ciclo', 'tipo', 'area', 'usuario', 'subarea', 'asunto', 'tipoSolicitud', 'categoriaServicio', 'status', 'tecnico'])->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ciclos = Ciclo::all();
        $tipos = Tipo::all();
        $areas = Area::all();
        $usuarios = Usuario::all();
        $subareas = Subarea::all();
        $asuntos = Asunto::all();
        $tipoSolicitudes = TipoSolicitud::all();
        $categoriasServicio = CategoriaServicio::all();
        $statuses = Status::all();
        $tecnicos = Tecnico::all();

        return view('tickets.edit', compact('ticket', 'ciclos', 'tipos', 'areas', 'usuarios', 'subareas', 'asuntos', 'tipoSolicitudes', 'categoriasServicio', 'statuses', 'tecnicos'));
    }

    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'ciclo_id' => $request->ciclo_id,
            'tipo_id' => $request->tipo_id,
            'fecha' => $request->fecha,
            'area_id' => $request->area_id,
            'usuario_id' => $request->usuario_id,
            'solicitud' => $request->solicitud,
            'subarea_id' => $request->subarea_id,
            'asunto_id' => $request->asunto_id,
            'tipo_solicitud_id' => $request->tipo_solicitud_id,
            'categoria_servicio_id' => $request->categoria_servicio_id,
            'status_id' => $request->status_id,
            'tecnico_id' => $request->tecnico_id,
            'incidencia_real' => $request->incidencia_real,
            'servicio_realizado' => $request->servicio_realizado,
            'fecha_atencion' => $request->fecha_atencion,
            'notas' => $request->notas,
            'observaciones' => $request->observaciones,
        ]);
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket actualizado exitosamente.');
    }

    /**
     * Show the completion form for a ticket
     */
    public function showComplete(string $id)
    {
        $ticket = Ticket::with(['ciclo', 'tipo', 'area', 'usuario', 'subarea', 'asunto', 'tipoSolicitud', 'categoriaServicio', 'status', 'tecnico'])->findOrFail($id);
        
        // Cargar datos necesarios para el formulario
        $tecnicos = Tecnico::all();
        $categoriasServicio = CategoriaServicio::all();
        $asuntos = Asunto::all();
        $tipoSolicitudes = TipoSolicitud::all();
        
        return view('tickets.completado', compact('ticket', 'tecnicos', 'categoriasServicio', 'asuntos', 'tipoSolicitudes'));
    }
    
    /**
     * Complete a ticket with all final information
     */
    public function complete(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Validar los campos requeridos para completar el ticket
        $request->validate([
            'tecnico_id' => 'required|exists:tecnicos,id',
            'categoria_servicio_id' => 'required|exists:categoria_servicios,id',
            'asunto_id' => 'required|exists:asuntos,id',
            'tipo_solicitud_id' => 'required|exists:tipo_solicituds,id',
            'incidencia_real' => 'required|string|min:1|max:1000',
            'servicio_realizado' => 'required|string|min:1|max:1000',
            'observaciones' => 'nullable|string|max:500',
            'fecha_atencion' => 'nullable|date'
        ]);
        
        // Buscar el status "Resuelto"
        $resolvedStatus = Status::where('status', 'Resuelto')->first();
        
        if (!$resolvedStatus) {
            return redirect()->back()->with('error', 'No se pudo encontrar el estado "Resuelto" en el sistema.');
        }
        
        // Actualizar el ticket con toda la información
        $ticket->update([
            'tecnico_id' => $request->tecnico_id,
            'categoria_servicio_id' => $request->categoria_servicio_id,
            'asunto_id' => $request->asunto_id,
            'tipo_solicitud_id' => $request->tipo_solicitud_id,
            'incidencia_real' => $request->incidencia_real,
            'servicio_realizado' => $request->servicio_realizado,
            'observaciones' => $request->observaciones,
            'fecha_atencion' => $request->fecha_atencion ?: now(),
            'status_id' => $resolvedStatus->id
        ]);
        
        return redirect()->route('tickets.show', $ticket->id)
                         ->with('success', 'Ticket completado exitosamente y marcado como resuelto.');
    }

    /**
     * Redirect to completion form instead of directly marking as resolved
     */
    public function markAsResolved(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Verificar si el ticket ya tiene toda la información necesaria
        if ($ticket->tecnico_id && $ticket->categoria_servicio_id && $ticket->incidencia_real && $ticket->servicio_realizado) {
            // Si ya tiene toda la información, marcarlo como resuelto directamente
            $resolvedStatus = Status::where('status', 'Resuelto')->first();
            
            if ($resolvedStatus) {
                $ticket->update([
                    'status_id' => $resolvedStatus->id,
                    'fecha_atencion' => $ticket->fecha_atencion ?: now()
                ]);
                return redirect()->back()->with('success', 'Ticket marcado como resuelto exitosamente.');
            }
        }
        
        // Si no tiene toda la información, redirigir al formulario de completado
        return redirect()->route('tickets.showComplete', $ticket->id)
                         ->with('info', 'Complete la información faltante para marcar el ticket como resuelto.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado exitosamente.');
    }
}
