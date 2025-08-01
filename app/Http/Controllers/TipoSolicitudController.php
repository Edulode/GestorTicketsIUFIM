<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoSolicitud;
Use App\Models\CategoriaServicio;

class TipoSolicitudController extends Controller
{
    public function index()
    {
        $tiposSolicitud = TipoSolicitud::with('categoriaServicio')->get();
        return view('tipos_solicitud.index', compact('tiposSolicitud'));
    }

    public function create()
    {
        $categorias = CategoriaServicio::select('id', 'categoria_servicio')->get();
        return view('tipos_solicitud.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        TipoSolicitud::create([
            'tipo_solicitud' => $request->tipo_solicitud,
            'categoria_servicio_id' => $request->categoria_servicio_id,
        ]);
        return redirect()->route('tipos_solicitud.index')->with('success', 'Tipo de solicitud creado exitosamente.');
    }

    

    public function show(string $id)
    {
        $tipoSolicitud = TipoSolicitud::with('categoriaServicio')->findOrFail($id);
        return view('tipos_solicitud.show', compact('tipoSolicitud'));
    }

    public function edit(string $id)
    {
        $tipoSolicitud = TipoSolicitud::findOrFail($id);
        $categorias = CategoriaServicio::select('id', 'categoria_servicio')->get();
        return view('tipos_solicitud.edit', compact('tipoSolicitud', 'categorias'));
    }

    public function update(Request $request, string $id)
    {
        $tipoSolicitud = TipoSolicitud::findOrFail($id);
        $tipoSolicitud->update([
            'tipo_solicitud' => $request->tipo_solicitud,
            'categoria_servicio_id' => $request->categoria_servicio_id,
        ]);
        return redirect()->route('tipos_solicitud.index')->with('success', 'Tipo de solicitud actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $tipoSolicitud = TipoSolicitud::findOrFail($id);
        $tipoSolicitud->delete();
        return redirect()->route('tipos_solicitud.index')->with('success', 'Tipo de solicitud eliminado exitosamente.');
    }
}
