<?php

namespace App\Http\Controllers;

use App\Models\Mensualidad;
use App\Models\AlumnoPlan;
use Illuminate\Http\Request;

class MensualidadController extends Controller
{
    public function index()
    {
        $mensualidades = Mensualidad::with('alumnoPlan')->orderByDesc('fecha_vencimiento')->paginate(10);
        return view('mensualidades.index', compact('mensualidades'));
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
        return view('mensualidades.show', compact('mensualidad'));
    }

    public function edit(Mensualidad $mensualidad)
    {
        $alumnoPlanes = AlumnoPlan::with('alumno')->get();
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

    public function destroy(Mensualidad $mensualidad)
    {
        $mensualidad->delete();

        return redirect()->route('mensualidades.index')->with('success', 'Mensualidad eliminada correctamente.');
    }
}
