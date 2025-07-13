<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use \App\Models\Plan;
use App\Services\GeneradorCuotasService;
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
    // Este método se encarga de almacenar un nuevo alumno en la base de datos
    // y, si se selecciona un plan, también crea un contrato asociado al alumno.
    // Se valida la información del formulario y se crea el alumno y el contrato
    // El método utiliza el servicio GeneradorCuotasService para generar las cuotas del contrato.
    // Finalmente, redirige al usuario a la lista de alumnos con un mensaje de éxito
    public function store(Request $request)
    {

        $request->validate([
            // Validaciones para los campos del formulario de creación de alumno
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
            // Validaciones para el plan_id
            'plan_id' => 'required|exists:planes,id', // Validación para el plan_id, asegurando que sea un ID válido de la tabla planes
            'fecha_inicio' => 'required|date',
            'duracion_meses' => 'required|integer',
            'num_cuotas' => 'required|integer',
            'monto_cuota' => 'required|integer',
            'pago_inicial' => 'required|integer',
            'meses_congelados' => 'required|integer',
        ]);


        // Crear el alumno con los datos del formulario
        // Se utiliza el método only para obtener solo los campos necesarios del request
        // Esto asegura que solo se guarden los campos relevantes en la base de datos
        $alumno = Alumno::create($request->only([
            'nombre_alumno',
            'apellido_paterno',
            'apellido_materno',
            'edad',
            'rut',
            'nivel',
            'grado',
            'estado',
            'contacto',
            'comentario',
        ]));

        // Preparar los datos del plan del alumno
        // Estos datos se utilizarán para crear un contrato asociado al alumno
        // Se utiliza Carbon para calcular la fecha de fin real del plan
        $datosPlan = [
        'alumno_id' => $alumno->id,
        'plan_id' => $request->plan_id,
        'fecha_inicio' => $request->fecha_inicio,
        'duracion_meses' => $request->duracion_meses,
        'estado' => 'activo',
        'num_cuotas' => $request->num_cuotas,
        'monto_cuota' => $request->monto_cuota,
        'pago_inicial' => $request->pago_inicial,
        'meses_congelados' => $request->meses_congelados,
        'fecha_fin_real' => Carbon::parse($request->fecha_inicio)->addMonths($request->duracion_meses),
    ];

        // Crear el contrato del alumno
        // Se utiliza el modelo AlumnoPlan para crear un nuevo registro en la base de datos
        // Este registro contendrá la información del plan asociado al alumno
        $alumnoPlan = \App\Models\AlumnoPlan::create($datosPlan);


        // Decodificar la lista de cuotas del request
        // La lista de cuotas se envía como un JSON y se decodifica para poder
        // crear las mensualidades asociadas al contrato del alumno
        $cuotasList = json_decode($request->input('cuotasList'), true);


        // Recorrer la lista de cuotas y crear las mensualidades
        // Por cada cuota en la lista, se crea un nuevo registro de mensualidad
        // asociado al contrato del alumno. Esto permite llevar un control de los pagos
        app(GeneradorCuotasService::class)->generar($alumnoPlan, $cuotasList);

        // dd() se utiliza para depurar y mostrar los datos antes de continuar
        // En un entorno de producción, se debería eliminar o comentar esta línea
        // dd() detiene la ejecución del script y muestra los datos proporcionados
        // Aquí se muestran los datos del plan, la lista de cuotas y el contrato del alumno
        // Esto es útil para verificar que los datos se han guardado correctamente
        // Puedes eliminar esta línea una vez que hayas verificado que todo funciona correctamente
        //




        // Redirigir al usuario a la lista de alumnos con un mensaje de éxito
        return redirect()->route('alumnos.index')->with('success', 'Alumno, contrato y mensualidades creadas correctamente.');
    }




    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        $planes = Plan::all();
    return view('alumnos.edit', compact('alumno', 'planes'));
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


    public function verContrato($id)
    {
        $alumno = Alumno::with(['alumnoPlan.plan'])->findOrFail($id);

        // Obtener todas las mensualidades del plan actual del alumno
        $mensualidades = [];
        if ($alumno->alumnoPlan) {
            $mensualidades = $alumno->alumnoPlan->mensualidades()->orderBy('nro_cuota')->get();
        }

        return view('alumnos.contrato', compact('alumno', 'mensualidades'));
    }
}
