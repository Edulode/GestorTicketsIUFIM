<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciclo;

class CicloController extends Controller
{
    public function index()
    {
        $ciclos = Ciclo::all();
        return view('ciclos.index', compact('ciclos'));
    }

    public function create()
    {
        return view('ciclos.create');
    }

    public function store(Request $request)
    {
        Ciclo::create([
            'ciclo' => $request->ciclo,
        ]);
        return redirect()->route('ciclos.index')->with('success', 'Ciclo created successfully.');
    }

    public function show(string $id)
    {
        $ciclo = Ciclo::findOrFail($id);
        return view('ciclos.show', compact('ciclo'));
    }

    public function edit(string $id)
    {
        $ciclo = Ciclo::findOrFail($id);
        return view('ciclos.edit', compact('ciclo'));
    }

    public function update(Request $request, string $id)
    {
        $ciclo = Ciclo::findOrFail($id);
        $ciclo->update([
            'ciclo' => $request->ciclo,
        ]);
        return redirect()->route('ciclos.index')->with('success', 'Ciclo updated successfully.');
    }

    public function destroy(string $id)
    {
        $ciclo = Ciclo::findOrFail($id);
        $ciclo->delete();
        return redirect()->route('ciclos.index')->with('success', 'Ciclo deleted successfully.');
    }
}
