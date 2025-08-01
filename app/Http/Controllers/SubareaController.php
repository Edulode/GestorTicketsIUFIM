<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subarea;
use App\Models\Area;

class SubareaController extends Controller
{
    public function index()
    {
        $subareas = Subarea::with('area')->get();
        return view('subareas.index', compact('subareas'));
    }

    public function create()
    {
        $areas = Area::all();
        return view('subareas.create', compact('areas'));
    }

    public function store(Request $request)
    {
        Subarea::create([
            'subarea' => $request->subarea,
            'area_id' => $request->area_id,
        ]);
        return redirect()->route('subareas.index')->with('success', 'Subarea created successfully.');
    }

    public function show(string $id)
    {
        $subarea = Subarea::with('area')->findOrFail($id);
        return view('subareas.show', compact('subarea'));
    }

    public function edit(string $id)
    {
        $subarea = Subarea::with('area')->findOrFail($id);
        $areas = Area::all();
        return view('subareas.edit', compact('subarea', 'areas'));
    }

    public function update(Request $request, string $id)
    {
        $subarea = Subarea::findOrFail($id);
        $subarea->update([
            'subarea' => $request->subarea,
            'area_id' => $request->area_id,
        ]);
        return redirect()->route('subareas.index')->with('success', 'Subarea updated successfully.');
    }

    public function destroy(string $id)
    {
        $subarea = Subarea::findOrFail($id);
        $subarea->delete();
        return redirect()->route('subareas.index')->with('success', 'Subarea deleted successfully.');
    }
}
