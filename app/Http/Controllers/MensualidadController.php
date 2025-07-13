<?php

namespace App\Http\Controllers;

use App\Models\Mensualidad;
use App\Models\AlumnoPlan;
use Carbon\Carbon;
use App\Models\Alumno;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MensualidadController extends Controller
{
    public function index()
    {
        /*  $mensualidades = Mensualidad::with('alumnoPlan')->orderByDesc('fecha_vencimiento')->paginate(10);
        return view('mensualidades.index', compact('mensualidades')); */
        $alumnosConContrato = Alumno::whereHas('alumnoPlan.plan')
            ->with(['alumnoPlan.plan', 'mensualidades'])
             ->paginate(10);

        // Trae mensualidades asociadas a esos alumnos
        $mensualidades = Mensualidad::with(['alumnoPlan.alumno', 'alumnoPlan.plan'])
            ->whereIn('alumno_plan_id', $alumnosConContrato->pluck('alumnoPlan.id'))
            ->get();

        return view('mensualidades.index', compact('alumnosConContrato', 'mensualidades'));
    }

    public function create()
    {
        $alumnoPlanes = AlumnoPlan::with('alumno')->get();
        return view('mensualidades.create', compact('alumnoPlanes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_plan_id' => 'required|exists:alumno_plan,id',
            'nro_cuota' => 'required|integer|min:1',
            'monto_cuota' => 'required|integer|min:0',
            'estado_pago' => 'required|string',
            'fecha_pago' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        Mensualidad::create($request->all());

        return redirect()->route('mensualidades.index')->with('success', 'Mensualidad registrada correctamente.');
    }

    public function show(Mensualidad $mensualidad)
    {
        return redirect()->route('mensualidades.index');
    }

    public function edit(Mensualidad $mensualidad)
    {


        $alumnoPlanes = AlumnoPlan::with('alumno', 'plan')->get();
        return view('mensualidades.edit', compact('mensualidad', 'alumnoPlanes'));
    }


    public function update(Request $request, Mensualidad $mensualidad)
    {
        $request->validate([
            'alumno_plan_id' => 'required|exists:alumno_plan,id',
            'nro_cuota' => 'required|integer|min:1',
            'monto_cuota' => 'required|integer|min:0',
            'estado_pago' => 'required|string',
            'fecha_pago' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        $mensualidad->update($request->all());

        return redirect()->route('mensualidades.index')->with('success', 'Mensualidad actualizada correctamente.');
    }

    //Actualiza el estado de la mensualidad desde la vista del contrato del alumno
    public function updateEstado(Request $request, $id)
    {
        $mensualidad = Mensualidad::findOrFail($id);
        $mensualidad->estado_pago = $request->estado_pago;
        $mensualidad->save(); 

        return back()->with('success', 'Estado de la cuota actualizado.');
    }


    // Actualiza el estado de las mensualidades a "vencido" si la fecha de vencimiento es anterior al día actual
    public function actualizarEstadosMensualidades()
    {
        //Obtener fecha actual
        $hoy = Carbon::today();

        // Buscar todas las mensualidades pendientes
        $mensualidades = Mensualidad::where('estado_pago', 'pendiente')->get();
        foreach ($mensualidades as $mensualidad) {
            if ($mensualidad->fecha_vencimiento && $mensualidad->fecha_vencimiento < $hoy) {
                $mensualidad->estado_pago = 'vencido';
                $mensualidad->save();
            }
        }

        return 'Estados actualizados correctamente.';
    }



    public function destroy(Mensualidad $mensualidad)
    {
        $mensualidad->delete();

        return redirect()->route('mensualidades.index')->with('success', 'Mensualidad eliminada correctamente.');
    }

    public function pagar(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'cuotas' => 'required|array',
            'cuotas.*' => 'exists:mensualidades,id'
        ]);

        DB::beginTransaction();

        try {
            // Actualiza las cuotas seleccionadas
            Mensualidad::whereIn('id', $request->cuotas)
                ->update([
                    'estado_pago' => 'pagado',
                    'fecha_pago' => now()
                ]);

            DB::commit();
            return redirect()->route('mensualidades.index')->with('success', 'Pago registrado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('mensualidades.index')->with('error', 'Error al registrar el pago: ' . $e->getMessage());
        }
    }
}
