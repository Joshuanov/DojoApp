<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MensualidadController;

//Controlador que invoca función de revisón de estado de mensualidades a penas se abre el dashboard
class DashboardController extends Controller
{
    public function index()
    {
        // Funcion que actualiza los estados de las mensualidades
        app(MensualidadController::class)->actualizarEstadosMensualidades();

        return view('dashboard');
    }
}