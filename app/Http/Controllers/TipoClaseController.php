<?php

namespace App\Http\Controllers;

use App\Models\TipoClase;
use Illuminate\Http\Request;

class TipoClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoClase::all();
        return view('tipo_clase.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipo_clase.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_clase' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion' => 'required|integer|min:1',
            'grupo' => 'required|string|max:255',
        ]);

        TipoClase::create($validated);

        return redirect()->route('tipo_clase.index')->with('success', 'Tipo de clase creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoClase $tipo_clase)
    {
        return view('tipo_clase.show', compact('tipo_clase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoClase $tipo_clase)
    {
        return view('tipo_clase.edit', compact('tipo_clase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoClase $tipo_clase)
    {
        $validated = $request->validate([
            'nombre_clase' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion' => 'required|integer|min:1',
            'grupo' => 'required|string|max:255',
        ]);

        $tipo_clase->update($validated);

        return redirect()->route('tipo_clase.index')->with('success', 'Tipo de clase actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoClase $tipo_clase)
    {
        $tipo_clase->delete();

        return redirect()->route('tipo_clase.index')->with('success', 'Tipo de clase eliminado correctamente.');
    }
}
