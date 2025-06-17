<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Alumno;
use App\Models\TipoClase;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::with(['alumno', 'tipoClase'])->orderByDesc('fecha')->paginate(10);
        return view('asistencias.index', compact('asistencias'));
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
