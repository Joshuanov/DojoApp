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
        return view('asistencias.create', compact('alumnos', 'tiposClase'));
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
}
