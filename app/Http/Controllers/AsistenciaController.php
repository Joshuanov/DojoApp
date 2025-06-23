<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Alumno;
use App\Models\TipoClase;
use Illuminate\Http\Request;



class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $asistencias = Asistencia::with(['alumno', 'tipoClase'])
            ->when($request->alumno, function ($query, $alumno) {
                $query->whereHas('alumno', function ($q) use ($alumno) {
                    $q->where('nombre_alumno', 'like', "%$alumno%")
                        ->orWhere('apellido_paterno', 'like', "%$alumno%")
                        ->orWhere('apellido_materno', 'like', "%$alumno%");
                });
            })
            ->when($request->tipo_clase, function ($query, $tipoClaseId) {
                $query->where('tipo_clase_id', $tipoClaseId);
            })
            ->when($request->filled('fecha_desde'), function ($query) use ($request) {
                $query->whereDate('fecha', '>=', $request->fecha_desde);
            })
            ->when($request->filled('fecha_hasta'), function ($query) use ($request) {
                $query->whereDate('fecha', '<=', $request->fecha_hasta);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tiposClase = TipoClase::all(); // Para el dropdown

        return view('asistencias.index', compact('asistencias', 'tiposClase'));
    }


    public function create()
    {
        $alumnos = Alumno::all();
        $tiposClase = TipoClase::all();
        $grupos = TipoClase::select('grupo')->distinct()->pluck('grupo');

        return view('asistencias.create', compact('alumnos', 'tiposClase', 'grupos'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'fecha' => 'required|date',
            'tipo_clase_id' => 'required|exists:tipo_clase,id',
            'estado' => 'required|string',
            'comentario' => 'nullable|string',
            'es_recuperacion' => 'nullable|boolean',
        ]);

        Asistencia::create($request->all());

        return redirect()->route('asistencias.index')->with('success', 'Asistencia registrada correctamente.');
    }

    public function show(Asistencia $asistencia)
    {
        return view('asistencias.show', compact('asistencia'));
    }

    public function edit(Asistencia $asistencia)
    {
        $alumnos = Alumno::all();
        $tiposClase = TipoClase::all();
        return view('asistencias.edit', compact('asistencia', 'alumnos', 'tiposClase'));
    }

    public function update(Request $request, Asistencia $asistencia)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'fecha' => 'required|date',
            'tipo_clase_id' => 'required|exists:tipo_clase,id',
            'estado' => 'required|string',
            'comentario' => 'nullable|string',
            'es_recuperacion' => 'nullable|boolean',
        ]);

        $asistencia->update($request->all());

        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente.');
    }

    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();

        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente.');
    }

    public function vistaMasiva()
    {
        $alumnos = Alumno::with(['asistencias.tipoClase'])->get();

        $tiposClase = TipoClase::all(); // para el formulario

        return view('asistencias.masiva', compact('alumnos', 'tiposClase'));
    }

    public function guardarMasiva(Request $request)
    {
        $request->validate([
            'tipo_clase_id' => 'required|exists:tipo_clase,id',
            'fecha' => 'required|date',
            'asistencias' => 'array',
        ]);

        foreach ($request->asistencias ?? [] as $alumnoId => $estado) {
            $existe = Asistencia::where('alumno_id', $alumnoId)
                ->where('fecha', $request->fecha)
                ->exists();

            if (!$existe) {
                Asistencia::create([
                    'alumno_id' => $alumnoId,
                    'tipo_clase_id' => $request->tipo_clase_id,
                    'fecha' => $request->fecha,
                    'estado' => $estado,
                    'es_recuperacion' => false,
                ]);
            }
        }

        return redirect()->route('asistencias.index')->with('success', 'Asistencias masivas registradas correctamente.');
    }
}
