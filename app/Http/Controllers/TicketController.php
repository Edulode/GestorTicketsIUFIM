<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\Area;
use App\Models\Subarea;
use App\Models\Usuario;
use App\Models\TipoSolicitud;
use App\Models\Tipo;
use App\Models\Asunto;
use App\Models\CategoriaServicio;
use App\Models\Status;
use App\Models\Tecnico;
use App\Helpers\CicloHelper;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['area', 'usuario', 'status'])->get();
        $areas = Area::orderBy('area')->get();
        return view('tickets.index', compact('tickets', 'areas'));
    }

    /**
     * API endpoint for AJAX requests to get tickets data
     */
    public function apiIndex(Request $request)
    {
        $query = Ticket::with(['area', 'usuario', 'status']);

        // Apply filters
        if ($request->filled('status')) {
            $query->whereHas('status', function($q) use ($request) {
                $q->where('status', $request->status);
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
                $q->where('solicitud', 'like', "%{$searchTerm}%")
                  ->orWhereHas('usuario', function($subQ) use ($searchTerm) {
                      $subQ->where('nombre', 'like', "%{$searchTerm}%")
                           ->orWhere('apellido_paterno', 'like', "%{$searchTerm}%")
                           ->orWhere('apellido_materno', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('area', function($subQ) use ($searchTerm) {
                      $subQ->where('area', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();

        // Calculate stats
        $total = $tickets->count();
        $pendientes = $tickets->filter(function($ticket) {
            return $ticket->status && $ticket->status->status === 'Pendiente';
        })->count();
        $completados = $tickets->filter(function($ticket) {
            return $ticket->status && $ticket->status->status === 'Resuelto';
        })->count();

        // Format tickets for JSON response
        $formattedTickets = $tickets->map(function($ticket) {
            $statusColors = [
                'Pendiente' => 'bg-yellow-100 text-yellow-800',
                'Resuelto' => 'bg-green-100 text-green-800'
            ];

            return [
                'id' => $ticket->id,
                'area_nombre' => $ticket->area ? $ticket->area->area : 'Sin área',
                'usuario_nombre' => $ticket->usuario ? 
                    $ticket->usuario->nombre . " " . $ticket->usuario->apellido_paterno . " " . $ticket->usuario->apellido_materno : 
                    'Sin usuario',
                'solicitud' => $ticket->solicitud,
                'fecha' => $ticket->created_at->format('d/m/Y'),
                'hora' => $ticket->created_at->format('H:i'),
                'status' => $ticket->status ? $ticket->status->status : 'Sin Estado',
                'status_color' => $ticket->status ? 
                    ($statusColors[$ticket->status->status] ?? 'bg-gray-100 text-gray-800') : 
                    'bg-gray-100 text-gray-800',
                'show_url' => route('tickets.show', $ticket->id),
                'edit_url' => route('tickets.edit', $ticket->id)
            ];
        });

        return response()->json([
            'tickets' => $formattedTickets,
            'total' => $total,
            'pendientes' => $pendientes,
            'completados' => $completados
        ]);
    }

    /**
     * API endpoint to get tipos de solicitud by categoria de servicio
     */
    public function getTiposSolicitudPorCategoria($categoria_id)
    {
        $tiposSolicitud = TipoSolicitud::where('categoria_servicio_id', $categoria_id)
                                      ->orderBy('tipo_solicitud')
                                      ->get(['id', 'tipo_solicitud']);
        
        return response()->json($tiposSolicitud);
    }

    public function create()
    {
        $ciclos = collect(CicloHelper::getTodosCiclos());
        $tipos = Tipo::all();
        $areas = Area::all();
        $usuarios = Usuario::all();
        $subareas = Subarea::all();
        $asuntos = Asunto::all();
        $tipoSolicitudes = TipoSolicitud::all();
        $categoriasServicio = CategoriaServicio::all();
        $statuses = Status::all();
        $tecnicos = Tecnico::all();
        
        // Obtener el ciclo actual automático
        $cicloActual = CicloHelper::getInfoCicloActual();

        return view('tickets.create', compact('ciclos', 'tipos', 'areas', 'usuarios', 'subareas', 'asuntos', 'tipoSolicitudes', 'categoriasServicio', 'statuses', 'tecnicos', 'cicloActual'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los campos requeridos
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'area_id' => 'required|exists:areas,id',
            'subarea_id' => 'required|exists:subareas,id',
            'solicitud' => 'required|string|max:1000',
        ]);

        // Obtener el ciclo actual automático
        $ciclo = $request->ciclo ?: CicloHelper::getCicloActual();

        // Crear el ticket con valores por defecto para campos requeridos
        Ticket::create([
            'ciclo' => $ciclo,
            'tipo_id' => $request->tipo_id ?? 1, // Default a "Externo"
            'fecha' => $request->fecha ?? now(),
            'area_id' => $request->area_id,
            'usuario_id' => $request->usuario_id,
            'solicitud' => $request->solicitud,
            'subarea_id' => $request->subarea_id,
            'asunto_id' => $request->asunto_id ?? 1, // Default a "Administrativo"
            'tipo_solicitud_id' => $request->tipo_solicitud_id ?? null,
            'categoria_servicio_id' => $request->categoria_servicio_id ?? null,
            'status_id' => $request->status_id ?? 1, // Default status
            'tecnico_id' => $request->tecnico_id ?? null,
            'incidencia_real' => $request->incidencia_real ?? null,
            'servicio_realizado' => $request->servicio_realizado ?? null,
            'fecha_atencion' => $request->fecha_atencion ?? null,
            'notas' => $request->notas ?? null,
            'observaciones' => $request->observaciones ?? null,
        ]);
        
        return redirect()->route('tickets.create')->with('success', 'Ticket creado exitosamente.');
    }

    public function show(string $id)
    {
        $ticket = Ticket::with(['tipo', 'area', 'usuario', 'subarea', 'asunto', 'tipoSolicitud', 'categoriaServicio', 'status', 'tecnico'])->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ciclos = collect(CicloHelper::getTodosCiclos());
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
            'ciclo' => $request->ciclo ?: CicloHelper::getCicloActual(),
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
     * Mark ticket as resolved
     */
    public function markAsResolved(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Buscar el status "Resuelto" (asumiendo que existe)
        $resolvedStatus = Status::where('status', 'Resuelto')->first();
        
        if ($resolvedStatus) {
            $ticket->update([
                'status_id' => $resolvedStatus->id,
                'fecha_atencion' => now()
            ]);
            return redirect()->back()->with('success', 'Ticket marcado como resuelto exitosamente.');
        }
        
        return redirect()->back()->with('error', 'No se pudo marcar el ticket como resuelto.');
    }

    /**
     * Show form to complete ticket with additional details
     */
    public function completar(string $id)
    {
        $ticket = Ticket::with(['tipo', 'area', 'usuario', 'subarea', 'asunto', 'tipoSolicitud', 'categoriaServicio', 'status', 'tecnico'])->findOrFail($id);
        $tecnicos = Tecnico::orderBy('nombre')->get();
        $tipoSolicitudes = TipoSolicitud::with('categoriaServicio')->orderBy('tipo_solicitud')->get();
        $categoriasServicio = CategoriaServicio::orderBy('categoria_servicio')->get();
        
        return view('tickets.completar', compact('ticket', 'tecnicos', 'tipoSolicitudes', 'categoriasServicio'));
    }

    /**
     * Complete ticket with additional details and mark as resolved
     */
    public function completarTicket(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        $request->validate([
            'incidencia_real' => 'required|string|max:1000',
            'servicio_realizado' => 'required|string|max:1000',
            'tecnico_id' => 'required|exists:tecnicos,id',
            'tipo_solicitud_id' => 'nullable|exists:tipo_solicituds,id',
            'categoria_servicio_id' => 'nullable|exists:categoria_servicios,id',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'incidencia_real.required' => 'La incidencia real es obligatoria.',
            'servicio_realizado.required' => 'El servicio realizado es obligatorio.',
            'tecnico_id.required' => 'Debe seleccionar un técnico.',
            'tecnico_id.exists' => 'El técnico seleccionado no existe.',
        ]);

        // Buscar el status "Resuelto"
        $resolvedStatus = Status::where('status', 'Resuelto')->first();
        
        if (!$resolvedStatus) {
            return redirect()->back()->with('error', 'No se encontró el estado "Resuelto" en el sistema.');
        }

        $ticket->update([
            'incidencia_real' => $request->incidencia_real,
            'servicio_realizado' => $request->servicio_realizado,
            'tecnico_id' => $request->tecnico_id,
            'tipo_solicitud_id' => $request->tipo_solicitud_id,
            'categoria_servicio_id' => $request->categoria_servicio_id,
            'observaciones' => $request->observaciones,
            'status_id' => $resolvedStatus->id,
            'fecha_atencion' => now()
        ]);
        
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket completado y marcado como resuelto exitosamente.');
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
