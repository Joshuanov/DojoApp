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

    
    // Muestra un listado de alumnos con el resumen de asistencia de la semana actual.
     
    public function listadoAlumnos(Request $request)
    {
        $inicioSemana = now()->startOfWeek();
        $finSemana = now()->endOfWeek();

        $alumnos = Alumno::with(['alumnoPlan.plan', 'asistencias' => function ($q) use ($inicioSemana, $finSemana) {
            $q->whereBetween('fecha', [$inicioSemana, $finSemana])
                ->where('estado', 'presente')
                ->with('tipoClase');
        }])
            ->when($request->busqueda, function ($query) use ($request) {
                $busqueda = $request->busqueda;
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre_alumno', 'like', "%$busqueda%")
                        ->orWhere('apellido_paterno', 'like', "%$busqueda%")
                        ->orWhere('apellido_materno', 'like', "%$busqueda%")
                        ->orWhere('grado', 'like', "%$busqueda%")
                        ->orWhere('grupo', 'like', "%$busqueda%");
                });
            })
            ->get();

        return view('asistencias.listado_alumnos', [
            'alumnos' => $alumnos,
            'busqueda' => $request->busqueda,
        ]);
    }
    
    public function increment(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'tipo' => 'required|in:tradicional,sanda',
        ]);

        $tipoClase = TipoClase::whereRaw('lower(nombre_clase) = ?', [$request->tipo])->first();

        if (!$tipoClase) {
            return response()->json(['error' => 'Tipo de clase no encontrado'], 404);
        }

        // Verificar si ya existe una asistencia para el alumno en la fecha actual
        Asistencia::create([
            'alumno_id' => $request->alumno_id,
            'fecha' => now(),
            'tipo_clase_id' => $tipoClase->id,
            'estado' => 'presente',
            'es_recuperacion' => false,
        ]);

        $inicioSemana = now()->startOfWeek();
        $finSemana = now()->endOfWeek();

        $asistenciasSemana = Asistencia::where('alumno_id', $request->alumno_id)
            ->whereBetween('fecha', [$inicioSemana, $finSemana])
            ->where('estado', 'presente')
            ->with('tipoClase')
            ->get();

        $trad = $asistenciasSemana->filter(fn($a) => strtolower(optional($a->tipoClase)->nombre_clase) === 'tradicional')->count();
        $sanda = $asistenciasSemana->filter(fn($a) => strtolower(optional($a->tipoClase)->nombre_clase) === 'sanda')->count();
        $total = $asistenciasSemana->count();

        return response()->json([
            'success' => true,
            'trad' => $trad,
            'sanda' => $sanda,
            'total' => $total,
        ]);
    }

    public function guardarCambios(Request $request)
    {
        $data = $request->validate([
            'cambios' => 'required|array',
            'cambios.*.alumno_id' => 'required|exists:alumnos,id',
            'cambios.*.trad' => 'integer',
            'cambios.*.sanda' => 'integer',
        ]);

        foreach ($data['cambios'] as $cambio) {
            $alumnoId = $cambio['alumno_id'];
            $alumno = Alumno::with('alumnoPlan.plan')->find($alumnoId);
            $plan = optional($alumno->alumnoPlan)->plan;

            $maxTrad = $plan->cant_clases_tradicional ?? 0;
            $maxSanda = $plan->cant_clases_sanda ?? 0;
            $totalMax = $maxTrad + $maxSanda;

            $inicioSemana = now()->startOfWeek();
            $finSemana = now()->endOfWeek();

            $asistenciasSemana = Asistencia::where('alumno_id', $alumnoId)
                ->whereBetween('fecha', [$inicioSemana, $finSemana])
                ->where('estado', 'presente')
                ->with('tipoClase')
                ->get();

            $tradCount = $asistenciasSemana->filter(fn($a) => strtolower(optional($a->tipoClase)->nombre_clase) === 'tradicional')->count();
            $sandaCount = $asistenciasSemana->filter(fn($a) => strtolower(optional($a->tipoClase)->nombre_clase) === 'sanda')->count();
            $totalCount = $tradCount + $sandaCount;

            $tipos = ['trad' => 'tradicional', 'sanda' => 'sanda'];
            foreach ($tipos as $key => $nombre) {
                $delta = $cambio[$key] ?? 0;
                if ($delta == 0) {
                    continue;
                }

                $tipoClase = TipoClase::whereRaw('lower(nombre_clase) = ?', [$nombre])->first();
                if (!$tipoClase) {
                    continue;
                }

                if ($delta > 0) {
                    for ($i = 0; $i < $delta; $i++) {
                        if ($totalCount >= $totalMax) {
                            break;
                        }
                        if ($key === 'trad' && $tradCount >= $maxTrad) {
                            break;
                        }
                        if ($key === 'sanda' && $sandaCount >= $maxSanda) {
                            break;
                        }

                        Asistencia::create([
                            'alumno_id' => $alumnoId,
                            'fecha' => now(),
                            'tipo_clase_id' => $tipoClase->id,
                            'estado' => 'presente',
                            'es_recuperacion' => false,
                        ]);

                        $totalCount++;
                        if ($key === 'trad') {
                            $tradCount++;
                        } else {
                            $sandaCount++;
                        }
                    }
                } else {
                    for ($i = 0; $i < abs($delta); $i++) {
                        $asistencia = Asistencia::where('alumno_id', $alumnoId)
                            ->where('tipo_clase_id', $tipoClase->id)
                            ->whereBetween('fecha', [$inicioSemana, $finSemana])
                            ->latest()
                            ->first();
                        if ($asistencia) {
                            $asistencia->delete();
                            $totalCount--;
                            if ($key === 'trad') {
                                $tradCount--;
                            } else {
                                $sandaCount--;
                            }
                        }
                    }
                }
            }
        }

        return response()->json(['success' => true]);
    }
}

