<?php

namespace App\Http\Controllers;

use App\Models\Subarea;
use Illuminate\Http\Request;

class SubareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subareas = Subarea::orderBy('subarea')->paginate(15);
        return view('subareas.index', compact('subareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subareas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subarea' => 'required|string|max:255|unique:subareas',
        ], [
            'subarea.required' => 'El nombre de la subárea es obligatorio.',
            'subarea.max' => 'El nombre de la subárea no puede exceder 255 caracteres.',
            'subarea.unique' => 'Ya existe una subárea con este nombre.',
        ]);

        Subarea::create([
            'subarea' => $request->subarea,
        ]);

        return redirect()->route('subareas.index')
                        ->with('success', 'Subárea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subarea $subarea)
    {
        return view('subareas.show', compact('subarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subarea $subarea)
    {
        return view('subareas.edit', compact('subarea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subarea $subarea)
    {
        $request->validate([
            'subarea' => 'required|string|max:255|unique:subareas,subarea,' . $subarea->id,
        ], [
            'subarea.required' => 'El nombre de la subárea es obligatorio.',
            'subarea.max' => 'El nombre de la subárea no puede exceder 255 caracteres.',
            'subarea.unique' => 'Ya existe una subárea con este nombre.',
        ]);

        $subarea->update([
            'subarea' => $request->subarea,
        ]);

        return redirect()->route('subareas.index')
                        ->with('success', 'Subárea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subarea $subarea)
    {
        // Verificar si hay tickets asociados a esta subárea
        if ($subarea->tickets()->count() > 0) {
            return redirect()->route('subareas.index')
                           ->with('error', 'No se puede eliminar la subárea porque tiene tickets asociados.');
        }
        
        $subarea->delete();

        return redirect()->route('subareas.index')
                        ->with('success', 'Subárea eliminada exitosamente.');
    }
}