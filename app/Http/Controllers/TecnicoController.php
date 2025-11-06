<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tecnico;

class TecnicoController extends Controller
{
    public function index()
    {
        $tecnicos = Tecnico::with('tickets')->orderBy('created_at', 'desc')->paginate(15);
        return view('tecnicos.index', compact('tecnicos'));
    }

    public function create()
    {
        return view('tecnicos.create');
    }

    public function store(Request $request)
    {
        Tecnico::create([
            'nombre' => $request->name,
            'apellidoP' => $request->apellidoP,
            'apellidoM' => $request->apellidoM,
            'status' => $request->has('status') ? true : false,
        ]);
        return redirect()->route('tecnicos.index')->with('success', 'Técnico creado exitosamente.');
    }

    public function show(string $id)
    {
        $tecnico = Tecnico::with(['tickets.status', 'tickets.usuario'])->findOrFail($id);
        return view('tecnicos.show', compact('tecnico'));
    }

    public function edit(string $id)
    {
        $tecnico = Tecnico::findOrFail($id);
        return view('tecnicos.edit', compact('tecnico'));
    }

    public function update(Request $request, string $id)
    {
        $tecnico = Tecnico::findOrFail($id);
        $tecnico->update([
            'nombre' => $request->name,
            'apellidoP' => $request->apellidoP,
            'apellidoM' => $request->apellidoM,
            'status' => $request->has('status') ? true : false,
        ]);
        return redirect()->route('tecnicos.index')->with('success', 'Técnico actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $tecnico = Tecnico::findOrFail($id);
        $tecnico->delete();
        return redirect()->route('tecnicos.index')->with('success', 'Técnico eliminado exitosamente.');
    }
}
