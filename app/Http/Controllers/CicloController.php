<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciclo;

class CicloController extends Controller
{
    public function index(Request $request)
    {
        $query = Ciclo::withCount('tickets');
        
        // Búsqueda
        if ($request->filled('search')) {
            $query->where('ciclo', 'like', '%' . $request->search . '%');
        }
        
        // Ordenamiento
        $sort = $request->get('sort', 'ciclo_asc');
        switch ($sort) {
            case 'ciclo_desc':
                $query->orderBy('ciclo', 'desc');
                break;
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'tickets_desc':
                $query->orderBy('tickets_count', 'desc');
                break;
            case 'tickets_asc':
                $query->orderBy('tickets_count', 'asc');
                break;
            default: // ciclo_asc
                $query->orderBy('ciclo', 'asc');
                break;
        }
        
        $ciclos = $query->paginate(15)->withQueryString();
        
        return view('ciclos.index', compact('ciclos'));
    }

    public function create()
    {
        return view('ciclos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ciclo' => 'required|string|max:255|unique:ciclos,ciclo',
        ], [
            'ciclo.required' => 'El nombre del ciclo es obligatorio.',
            'ciclo.string' => 'El nombre del ciclo debe ser un texto válido.',
            'ciclo.max' => 'El nombre del ciclo no puede tener más de 255 caracteres.',
            'ciclo.unique' => 'Ya existe un ciclo con este nombre.',
        ]);

        Ciclo::create([
            'ciclo' => $request->ciclo,
        ]);
        
        return redirect()->route('ciclos.index')->with('success', 'Ciclo creado exitosamente.');
    }

    public function show(string $id)
    {
        $ciclo = Ciclo::with(['tickets.status'])->findOrFail($id);
        return view('ciclos.show', compact('ciclo'));
    }

    public function edit(string $id)
    {
        $ciclo = Ciclo::with('tickets')->findOrFail($id);
        return view('ciclos.edit', compact('ciclo'));
    }

    public function update(Request $request, string $id)
    {
        $ciclo = Ciclo::findOrFail($id);
        
        $request->validate([
            'ciclo' => 'required|string|max:255|unique:ciclos,ciclo,' . $ciclo->id,
        ], [
            'ciclo.required' => 'El nombre del ciclo es obligatorio.',
            'ciclo.string' => 'El nombre del ciclo debe ser un texto válido.',
            'ciclo.max' => 'El nombre del ciclo no puede tener más de 255 caracteres.',
            'ciclo.unique' => 'Ya existe un ciclo con este nombre.',
        ]);

        $ciclo->update([
            'ciclo' => $request->ciclo,
        ]);
        
        return redirect()->route('ciclos.index')->with('success', 'Ciclo actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $ciclo = Ciclo::findOrFail($id);
        
        // Verificar que no tenga tickets asociados
        if ($ciclo->tickets()->count() > 0) {
            return redirect()->route('ciclos.index')->with('error', 'No se puede eliminar el ciclo porque tiene tickets asociados.');
        }
        
        $ciclo->delete();
        
        return redirect()->route('ciclos.index')->with('success', 'Ciclo eliminado exitosamente.');
    }
}
