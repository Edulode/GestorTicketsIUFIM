<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriaServicioController extends Controller
{
    public function index()
    {
        $categorias = CategoriaServicio::all();
        return view('categoria_servicio.index', compact('categorias'));
    }

    public function create()
    {
        return view('categoria_servicio.create');
    }

    public function store(Request $request)
    {
        CategoriaServicio::create([
            'categoria_servicio' => $request->categoria_servicio,
        ]);
        return redirect()->route('categoria_servicio.index')->with('success', 'Categoría de servicio creada exitosamente.');
    }

    public function show(string $id)
    {
        $categoria = CategoriaServicio::findOrFail($id);
        return view('categoria_servicio.show', compact('categoria'));
    }

    public function edit(string $id)
    {
        $categoria = CategoriaServicio::findOrFail($id);
        return view('categoria_servicio.edit', compact('categoria'));
    }

    public function update(Request $request, string $id)
    {
        $categoria = CategoriaServicio::findOrFail($id);
        $categoria->update([
            'categoria_servicio' => $request->categoria_servicio,
        ]);
        return redirect()->route('categoria_servicio.index')->with('success', 'Categoría de servicio actualizada exitosamente.');
    }

    public function destroy(string $id)
    {
        $categoria = CategoriaServicio::findOrFail($id);
        $categoria->delete();
        return redirect()->route('categoria_servicio.index')->with('success', 'Categoría de servicio eliminada exitosamente.');
    }
}
