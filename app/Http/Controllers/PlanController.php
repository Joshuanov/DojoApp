<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $planes = Plan::all();
        return view('planes.index', compact('planes'));
    }

    public function create()
    {
        return view('planes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_plan' => 'required|string',
            'descripcion' => 'nullable|string',
            'duracion_meses' => 'required|integer',
            'valor_total' => 'required|integer',
        ]);

        Plan::create($request->all());

        return redirect()->route('planes.index')->with('success', 'Plan creado correctamente.');
    }

    public function show(Plan $plan)
    {
        return view('planes.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return view('planes.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'nombre_plan' => 'required|string',
            'descripcion' => 'nullable|string',
            'duracion_meses' => 'required|integer',
            'valor_total' => 'required|integer',
        ]);

        $plan->update($request->all());

        return redirect()->route('planes.index')->with('success', 'Plan actualizado correctamente.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('planes.index')->with('success', 'Plan eliminado correctamente.');
    }
}
