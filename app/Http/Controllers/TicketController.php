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
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
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

        return view('tickets.create', compact('ciclos', 'tipos', 'areas', 'usuarios', 'subareas', 'asuntos', 'tipoSolicitudes', 'categoriasServicio', 'statuses', 'tecnicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Ticket::create([
            'ciclo_id' => $request->ciclo_id,
            'tipo_id' => $request->tipo_id,
            'fecha' => $request->fecha,
            'area_id' => $request->area_id,
            'usuario_id' => $request->usuario_id,
            'solicitud' => $request->solicitud,
            'subarea_id' => $request->subarea_id,
            'asunto_id' => $request->asunto_id,
            'tipo_solicitud_id' => $request->tipo_solicitud_id,
            'categoria_servicio_id' => $request->categoria_servicio_id->nullable(),
            'status_id' => $request->status_id->nullable(),
            'tecnico_id' => $request->tecnico_id->nullable(),
            'incidencia_real' => $request->incidencia_real->nullable(),
            'servicio_realizado' => $request->servicio_realizado->nullable(),
            'fecha_atencion' => $request->fecha_atencion->nullable(),
            'notas' => $request->notas->nullable(),
            'observaciones' => $request->observaciones->nullable(),
        ]);
        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
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
            'categoria_servicio_id' => $request->categoria_servicio_id->nullable(),
            'status_id' => $request->status_id->nullable(),
            'tecnico_id' => $request->tecnico_id->nullable(),
            'incidencia_real' => $request->incidencia_real->nullable(),
            'servicio_realizado' => $request->servicio_realizado->nullable(),
            'fecha_atencion' => $request->fecha_atencion->nullable(),
            'notas' => $request->notas->nullable(),
            'observaciones' => $request->observaciones->nullable(),
        ]);
        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
