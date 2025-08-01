<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Subarea;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        Area::create([
            'area' => $request->area,
        ]);
        return redirect()->route('areas.index')->with('success', 'Área creada exitosamente.');
    }

    public function show(string $id)
    {
        $area = Area::findOrFail($id);
        return view('areas.show', compact('area'));
    }

    public function edit(string $id)
    {
        $area = Area::findOrFail($id);
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, string $id)
    {
        $area = Area::findOrFail($id);
        $area->update([
            'area' => $request->area,
        ]);
        return redirect()->route('areas.index')->with('success', 'Área actualizada exitosamente.');
    }

    public function destroy(string $id)
    {
        $area = Area::findOrFail($id);
        $area->delete();
        return redirect()->route('areas.index')->with('success', 'Área eliminada exitosamente.');
    }
}
