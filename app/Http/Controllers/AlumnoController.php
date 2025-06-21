<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumno::query();

        if ($request->filled('busqueda')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre_alumno', 'like', '%' . $request->busqueda . '%')
                    ->orWhere('apellido_paterno', 'like', '%' . $request->busqueda . '%')
                    ->orWhere('apellido_materno', 'like', '%' . $request->busqueda . '%');
            });
        }

        $alumnos = $query->orderBy('apellido_paterno')->paginate(10)->withQueryString();

        return view('alumnos.index', compact('alumnos'));
    }


    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
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
        ]);

        Alumno::create($request->all());

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
