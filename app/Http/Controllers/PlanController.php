<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
  public function index(Request $request)
{
    $query = Plan::query();

    if ($request->filled('busqueda')) {
        $query->where('nombre_plan', 'like', '%' . $request->busqueda . '%');
    }

    $planes = $query->paginate(10);

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
            'duracion_meses' => 'required|integer',
            'monto_total' => 'required|integer',
            'monto_base_mensual' => 'required|integer',
            'pago_inicial' => 'required|integer',
            'tipo_plan_pago' => 'required|string',
            'cant_clases_tradicional' => 'required|integer',
            'cant_clases_sanda' => 'required|integer',
            'cant_clases_extra' => 'required|integer',
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
            'duracion_meses' => 'required|integer',
            'monto_total' => 'required|integer',
            'monto_base_mensual' => 'required|integer',
            'pago_inicial' => 'required|integer',
            'tipo_plan_pago' => 'required|string',
            'cant_clases_tradicional' => 'required|integer',
            'cant_clases_sanda' => 'required|integer',
            'cant_clases_extra' => 'required|integer',
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
