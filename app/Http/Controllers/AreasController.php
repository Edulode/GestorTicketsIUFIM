<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = Area::withCount(['usuarios', 'subareas'])
                    ->orderBy('area')
                    ->paginate(10);

        return view('areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('areas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'area' => 'required|string|max:255|unique:areas,area',
            'descripcion' => 'nullable|string|max:500',
        ], [
            'area.required' => 'El nombre del área es obligatorio.',
            'area.unique' => 'Ya existe un área con este nombre.',
            'area.max' => 'El nombre del área no puede exceder 255 caracteres.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.',
        ]);

        Area::create($request->all());

        return redirect()->route('areas.index')
                        ->with('success', 'Área creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        $area->load(['usuarios', 'subareas']);
        
        // Obtener usuarios recientes del área
        $usuariosRecientes = $area->usuarios()
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        // Obtener tickets del área
        $ticketsRecientes = $area->usuarios()
                                ->with('tickets.status', 'tickets.asunto', 'tickets.tipo')
                                ->get()
                                ->pluck('tickets')
                                ->flatten()
                                ->sortByDesc('created_at')
                                ->take(10);

        return view('areas.show', compact('area', 'usuariosRecientes', 'ticketsRecientes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        return view('areas.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'area' => 'required|string|max:255|unique:areas,area,' . $area->id,
            'descripcion' => 'nullable|string|max:500',
        ], [
            'area.required' => 'El nombre del área es obligatorio.',
            'area.unique' => 'Ya existe un área con este nombre.',
            'area.max' => 'El nombre del área no puede exceder 255 caracteres.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.',
        ]);

        $area->update($request->all());

        return redirect()->route('areas.index')
                        ->with('success', 'Área actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        // Verificar si tiene usuarios o subareas asociadas
        if ($area->usuarios()->count() > 0) {
            return redirect()->route('areas.index')
                           ->with('error', 'No se puede eliminar el área porque tiene usuarios asignados.');
        }

        if ($area->subareas()->count() > 0) {
            return redirect()->route('areas.index')
                           ->with('error', 'No se puede eliminar el área porque tiene subáreas asociadas.');
        }

        $area->delete();

        return redirect()->route('areas.index')
                        ->with('success', 'Área eliminada exitosamente.');
    }
}