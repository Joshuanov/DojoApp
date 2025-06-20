<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use \App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;



class AlumnoController extends Controller
{
  public function index(Request $request)
{
    $query = Alumno::query();

    if ($request->filled('busqueda')) {
        $query->where('nombre_alumno', 'like', '%' . $request->busqueda . '%')
              ->orWhere('apellido_paterno', 'like', '%' . $request->busqueda . '%')
              ->orWhere('apellido_materno', 'like', '%' . $request->busqueda . '%');
    }

    $alumnos = $query->paginate(10);

    return view('alumnos.index', compact('alumnos'));
}


    public function create()
    {    
        $planes = Plan::all(); 

        return view('alumnos.create', compact('planes'));
    }

    //GUARDAR
    public function store(Request $request)
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);


        $request->validate([
            'nombre_alumno' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'edad' => 'required|integer',
            'rut' => 'required|string|unique:alumnos,rut',
            'nivel' => 'required|string',
            'grado' => 'required|string',
            'estado' => 'required|string',
            'contacto' => 'required|string',
            'comentario' => 'nullable|string',
            'plan_id' => ['nullable', 'numeric', Rule::exists('planes', 'id')],
        ]);

        logger('Pasó la validación');


        // Crear el alumno, excluyendo plan_id porque no va en la tabla alumnos
        $alumno = Alumno::create($request->except('plan_id'));

        // Log para depurar si se está recibiendo el plan_id
        logger('plan_id recibido: ' . $request->plan_id);

        // Si el plan fue seleccionado, crear el contrato
        if ($request->filled('plan_id')) {
        $plan = \App\Models\Plan::find($request->plan_id);


        //Calculo de fecha de fin de plan con Carbon
        $fecha_fin = Carbon::now()->addMonths($plan->duracion_meses + 0); // 0 = meses_congelados iniciales

        \App\Models\AlumnoPlan::create([
            'alumno_id'       => $alumno->id,
            'plan_id'         => $plan->id,
            'fecha_inicio'    => now(),
            'duracion_meses'  => $plan->duracion_meses,
            'num_cuotas'      => $plan->duracion_meses,
            'monto_cuota'     => $plan->monto_base_mensual,
            'pago_inicial'    => $plan->pago_inicial,
            'estado'          => 'activo',
            'meses_congelados' => 0,
            'fecha_fin_real'    => $fecha_fin,

            
        ]);
    }

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente.');
    }




    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'nombre_alumno' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'edad' => 'required|integer',
            'rut' => 'required|string|unique:alumnos,rut,' . $alumno->id,
            'nivel' => 'required|string',
            'grado' => 'required|string',
            'estado' => 'required|string',
            'contacto' => 'required|string',
            'comentario' => 'nullable|string',
        ]);

        $alumno->update($request->all());

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}
