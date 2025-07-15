<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MensualidadController;
use App\Models\Mensualidad;
use Illuminate\Support\Facades\Auth;

//Controlador que invoca función de revisón de estado de mensualidades a penas se abre el dashboard
class DashboardController extends Controller
{
    public function index()
    {
        // Funcion que actualiza los estados de las mensualidades
        app(MensualidadController::class)->actualizarEstadosMensualidades();

        // Contar las mensualidades vencidas desde la última revisión
        $user = Auth::user();
        // Si el usuario no tiene una fecha de revisión, se usa la fecha de creación
        $lastCheck = $user->vencidos_checked_at ?? $user->created_at;
        
        //
        $nuevasCuotas = Mensualidad::where('estado_pago', 'vencido')
            ->where('fecha_vencimiento', '>=', $lastCheck)
            ->count();


        return view('dashboard', compact('nuevasCuotas'));
    }
}