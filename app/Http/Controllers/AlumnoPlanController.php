<?php

namespace App\Http\Controllers;

use App\Models\AlumnoPlan;
use App\Models\Alumno;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlumnoPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = AlumnoPlan::with('alumno', 'plan'); // Asegúrate de tener estas relaciones definidas en el modelo

        if ($request->filled('busqueda')) {
            $query->whereHas('alumno', function ($q) use ($request) {
                $q->where('nombre_alumno', 'like', '%' . $request->busqueda . '%')
                    ->orWhere('apellido_paterno', 'like', '%' . $request->busqueda . '%')
                    ->orWhere('apellido_materno', 'like', '%' . $request->busqueda . '%');
            })->orWhereHas('plan', function ($q) use ($request) {
                $q->where('nombre_plan', 'like', '%' . $request->busqueda . '%');
            })->orWhere('estado', 'like', '%' . $request->busqueda . '%')
                ->orWhere('fecha_inicio', 'like', '%' . $request->busqueda . '%')
                ->orWhere('fecha_fin_real', 'like', '%' . $request->busqueda . '%');
        }

        $alumnoPlanes = $query->paginate(10);

        return view('alumno_plan.index', ['alumnosPlanes' => $alumnoPlanes]);
    }



    public function create()
    {
        $alumnos = Alumno::select('id', 'nombre_alumno', 'apellido_paterno', 'apellido_materno')->get();
        $planes = Plan::select('id', 'nombre_plan')->get();

        return view('alumno_plan.create', [
            'alumnos' => $alumnos,
            'planes' => $planes
        ]);
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
        ]);

        $datos = $request->all();
        $datos['fecha_fin_real'] = Carbon::parse($request->fecha_inicio)->addMonths($request->duracion_meses);

        AlumnoPlan::create($datos);

        return redirect()->route('alumno_plan.index')->with('success', 'Plan de alumno creado correctamente.');
    }

    public function show(AlumnoPlan $alumnoPlan)
    {
        return view('alumno_plan.show', compact('alumnoPlan'));
    }

    public function edit(AlumnoPlan $alumnoPlan)
    {
        $alumnos = Alumno::whereHas('planes')->get(); // o el nombre real de la relación

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
        ]);

        $datos = $request->all();
        $datos['fecha_fin_real'] = Carbon::parse($request->fecha_inicio)->addMonths($request->duracion_meses);

        $alumnoPlan->update($datos);

        return redirect()->route('alumno_plan.index')->with('success', 'Plan de alumno actualizado correctamente.');
    }

    public function destroy(AlumnoPlan $alumnoPlan)
    {
        $alumnoPlan->delete();

        return redirect()->route('alumno_plan.index')->with('success', 'Plan de alumno eliminado correctamente.');
    }
}
