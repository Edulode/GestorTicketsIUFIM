<?php

namespace App\Http\Controllers;

use App\Models\Subarea;
use App\Models\Area;
use Illuminate\Http\Request;

class SubareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subareas = Subarea::with('area')
                          ->orderBy('subarea')
                          ->paginate(10);

        return view('subareas.index', compact('subareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::orderBy('area')->get();
        
        // Si viene un área específica en la URL
        $selectedArea = request('area');
        
        return view('subareas.create', compact('areas', 'selectedArea'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subarea' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'descripcion' => 'nullable|string|max:500',
        ], [
            'subarea.required' => 'El nombre de la subárea es obligatorio.',
            'subarea.max' => 'El nombre de la subárea no puede exceder 255 caracteres.',
            'area_id.required' => 'Debe seleccionar un área.',
            'area_id.exists' => 'El área seleccionada no existe.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.',
        ]);

        // Verificar que no exista otra subárea con el mismo nombre en la misma área
        $exists = Subarea::where('subarea', $request->subarea)
                         ->where('area_id', $request->area_id)
                         ->exists();

        if ($exists) {
            return back()->withErrors(['subarea' => 'Ya existe una subárea con este nombre en el área seleccionada.'])
                        ->withInput();
        }

        Subarea::create($request->all());

        return redirect()->route('subareas.index')
                        ->with('success', 'Subárea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subarea $subarea)
    {
        $subarea->load('area');
        
        return view('subareas.show', compact('subarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subarea $subarea)
    {
        $areas = Area::orderBy('area')->get();
        
        return view('subareas.edit', compact('subarea', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subarea $subarea)
    {
        $request->validate([
            'subarea' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'descripcion' => 'nullable|string|max:500',
        ], [
            'subarea.required' => 'El nombre de la subárea es obligatorio.',
            'subarea.max' => 'El nombre de la subárea no puede exceder 255 caracteres.',
            'area_id.required' => 'Debe seleccionar un área.',
            'area_id.exists' => 'El área seleccionada no existe.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.',
        ]);

        // Verificar que no exista otra subárea con el mismo nombre en la misma área (excluyendo la actual)
        $exists = Subarea::where('subarea', $request->subarea)
                         ->where('area_id', $request->area_id)
                         ->where('id', '!=', $subarea->id)
                         ->exists();

        if ($exists) {
            return back()->withErrors(['subarea' => 'Ya existe una subárea con este nombre en el área seleccionada.'])
                        ->withInput();
        }

        $subarea->update($request->all());

        return redirect()->route('subareas.index')
                        ->with('success', 'Subárea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subarea $subarea)
    {
        // Aquí podrías verificar si hay tickets o usuarios asignados a esta subárea
        // En este caso no hay relaciones directas, pero podrías agregarlas en el futuro
        
        $subarea->delete();

        return redirect()->route('subareas.index')
                        ->with('success', 'Subárea eliminada exitosamente.');
    }
}