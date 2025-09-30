<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Area;

class UsuariosController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('area')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $areas = Area::orderBy('area')->get();
        return view('usuarios.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'area_id' => 'required|exists:areas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'area_id.required' => 'Debe seleccionar un área.',
            'area_id.exists' => 'El área seleccionada no existe.',
        ]);

        Usuario::create($request->all());
        
        return redirect()->route('usuarios.index')
                        ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(string $id)
    {
        $usuario = Usuario::with(['area', 'tickets.status', 'tickets.asunto', 'tickets.tipo'])
                          ->findOrFail($id);
        
        $ticketsRecientes = $usuario->tickets()
                                   ->with(['status', 'asunto', 'tipo'])
                                   ->orderBy('created_at', 'desc')
                                   ->limit(10)
                                   ->get();
        
        return view('usuarios.show', compact('usuario', 'ticketsRecientes'));
    }

    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        $areas = Area::orderBy('area')->get();
        return view('usuarios.edit', compact('usuario', 'areas'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'area_id' => 'required|exists:areas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'area_id.required' => 'Debe seleccionar un área.',
            'area_id.exists' => 'El área seleccionada no existe.',
        ]);

        $usuario->update($request->all());
        
        return redirect()->route('usuarios.index')
                        ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        // Verificar si tiene tickets asociados
        if ($usuario->tickets()->count() > 0) {
            return redirect()->route('usuarios.index')
                           ->with('error', 'No se puede eliminar el usuario porque tiene tickets asociados.');
        }
        
        $usuario->delete();
        
        return redirect()->route('usuarios.index')
                        ->with('success', 'Usuario eliminado exitosamente.');
    }
}
