<?php

namespace App\Http\Controllers;

use App\Models\AlumnoPlan;
use App\Models\Alumno;
use App\Models\Plan;
use Illuminate\Http\Request;

class AlumnoPlanController extends Controller
{
    public function index()
    {
        $alumnosPlanes = AlumnoPlan::with(['alumno', 'plan'])->paginate(10);
        return view('alumno_plan.index', compact('alumnosPlanes'));
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $planes = Plan::all();
        return view('alumno_plan.create', compact('alumnos', 'planes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'plan_id' => 'required|exists:planes,id',
            'fecha_inicio' => 'required|date',
            'duracion_meses' => 'required|integer',
            'estado' => 'required|string',
            'num_cuotas' => 'required|integer',
            'monto_cuota' => 'required|integer',
            'pago_inicial' => 'required|integer',
            'observaciones' => 'nullable|string',
            'meses_congelados' => 'required|integer',
            'fecha_fin_real' => 'required|date',
        ]);

        AlumnoPlan::create($request->all());

        return redirect()->route('alumno_plan.index')->with('success', 'Plan de alumno creado correctamente.');
    }

    public function show(AlumnoPlan $alumnoPlan)
    {
        return view('alumno_plan.show', compact('alumnoPlan'));
    }

    public function edit(AlumnoPlan $alumnoPlan)
    {
        $alumnos = Alumno::all();
        $planes = Plan::all();
        return view('alumno_plan.edit', compact('alumnoPlan', 'alumnos', 'planes'));
    }

    public function update(Request $request, AlumnoPlan $alumnoPlan)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'plan_id' => 'required|exists:planes,id',
            'fecha_inicio' => 'required|date',
            'duracion_meses' => 'required|integer',
            'estado' => 'required|string',
            'num_cuotas' => 'required|integer',
            'monto_cuota' => 'required|integer',
            'pago_inicial' => 'required|integer',
            'observaciones' => 'nullable|string',
            'meses_congelados' => 'required|integer',
            'fecha_fin_real' => 'required|date',
        ]);

        $alumnoPlan->update($request->all());

        return redirect()->route('alumno_plan.index')->with('success', 'Plan de alumno actualizado correctamente.');
    }

    public function destroy(AlumnoPlan $alumnoPlan)
    {
        $alumnoPlan->delete();

        return redirect()->route('alumno_plan.index')->with('success', 'Plan de alumno eliminado correctamente.');
    }
}
