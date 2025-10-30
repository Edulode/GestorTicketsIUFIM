<?php

namespace App\Http\Controllers;

use App\Models\CategoriaServicio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CategoriaServicio::withCount(['tiposSolicitud', 'tickets']);
        
        // Filtro de búsqueda
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('categoria_servicio', 'LIKE', "%{$searchTerm}%");
        }
        
        // Ordenamiento
        switch ($request->get('sort', 'categoria_servicio')) {
            case 'categoria_servicio_desc':
                $query->orderBy('categoria_servicio', 'desc');
                break;
            case 'tipos_count':
                $query->orderBy('tipos_solicitud_count', 'desc');
                break;
            case 'tickets_count':
                $query->orderBy('tickets_count', 'desc');
                break;
            default:
                $query->orderBy('categoria_servicio', 'asc');
                break;
        }
        
        $categorias = $query->get();
        
        return view('categoria_servicio.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria_servicio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoria_servicio' => [
                'required',
                'string',
                'max:255',
                'unique:categoria_servicios,categoria_servicio'
            ],
        ], [
            'categoria_servicio.required' => 'El nombre de la categoría es obligatorio.',
            'categoria_servicio.string' => 'El nombre de la categoría debe ser texto.',
            'categoria_servicio.max' => 'El nombre de la categoría no puede exceder 255 caracteres.',
            'categoria_servicio.unique' => 'Ya existe una categoría con este nombre.',
        ]);
        
        try {
            CategoriaServicio::create([
                'categoria_servicio' => trim($request->categoria_servicio),
            ]);
            
            return redirect()->route('categorias-servicio.index')
                ->with('success', 'Categoría de servicio creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la categoría de servicio. Inténtelo nuevamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = CategoriaServicio::with(['tiposSolicitud', 'tickets.usuario', 'tickets.status'])
            ->findOrFail($id);
        
        return view('categoria_servicio.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoria = CategoriaServicio::findOrFail($id);
        return view('categoria_servicio.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = CategoriaServicio::findOrFail($id);
        
        $request->validate([
            'categoria_servicio' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categoria_servicios', 'categoria_servicio')->ignore($categoria->id)
            ],
        ], [
            'categoria_servicio.required' => 'El nombre de la categoría es obligatorio.',
            'categoria_servicio.string' => 'El nombre de la categoría debe ser texto.',
            'categoria_servicio.max' => 'El nombre de la categoría no puede exceder 255 caracteres.',
            'categoria_servicio.unique' => 'Ya existe una categoría con este nombre.',
        ]);
        
        try {
            $categoria->update([
                'categoria_servicio' => trim($request->categoria_servicio),
            ]);
            
            return redirect()->route('categorias-servicio.index')
                ->with('success', 'Categoría de servicio actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la categoría de servicio. Inténtelo nuevamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $categoria = CategoriaServicio::withCount(['tiposSolicitud', 'tickets'])->findOrFail($id);
            
            // Verificar si tiene relaciones
            if ($categoria->tipos_solicitud_count > 0 || $categoria->tickets_count > 0) {
                return redirect()->route('categorias-servicio.index')
                    ->with('error', 'No se puede eliminar la categoría porque tiene tipos de solicitud o tickets asociados.');
            }
            
            $categoria->delete();
            
            return redirect()->route('categorias-servicio.index')
                ->with('success', 'Categoría de servicio eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('categorias-servicio.index')
                ->with('error', 'Error al eliminar la categoría de servicio. Inténtelo nuevamente.');
        }
    }
}
