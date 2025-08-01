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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create', [
            'ciclos' => Ciclo::all(),
            'areas' => Area::all(),
            'subareas' => Subarea::all(),
            'usuarios' => Usuario::all(),
            'tipos_solicitud' => TipoSolicitud::all(),
            'tipos' => Tipo::all(),
            'asuntos' => Asunto::all(),
            'categorias_servicio' => CategoriaServicio::all(),
            'statuses' => Status::all(),
            'tecnicos' => Tecnico::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ciclo_id' => 'required|exists:ciclos,id',
            'tipo_id' => 'required|exists:tipos,id',
            'fecha' => 'required|date',
            'area_id' => 'required|exists:areas,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'solicitud' => 'required|string',
            'subarea_id' => 'required|exists:subareas,id',
            'asunto_id' => 'required|exists:asuntos,id',
            'tipo_solicitud_id' => 'required|exists:tipos_solicitud,id',
            'categoria_servicio_id' => 'required|exists:categorias_servicio,id',
            'status_id' => 'required|exists:statuses,id',
            'tecnico_id' => 'nullable|exists:tecnicos,id',
            'incidencia_real' => 'nullable|string',
            'servicio_realizado' => 'nullable|string',
            'fecha_atencion' => 'nullable|date',
            'notas' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        Ticket::create($request->all());

        return redirect()->route('tickets.create')->with('success', 'Ticket creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
