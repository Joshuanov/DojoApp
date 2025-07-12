<?php

namespace App\Services;

use App\Models\Mensualidad;
use Carbon\Carbon;

// Este servicio se encarga de actualizar el estado de las mensualidades pendientes de un alumno
// Si la fecha de hoy es mayor a la fecha de vencimiento, el estado cambia a "vencido"
class EstadoMensualidadService {

    public function actualizarEstadosMensualidades($alumno)
    {
        //Se obtiene fecha actual
        $hoy = Carbon::today();

        // Se obtienen mensualidades pendientes del alumno para revisar si hay vencidas
        $mensualidades = $alumno->alumnoPlan->mensualidades()->where('estado_pago', 'pendiente')->get();

        // Recorremos el arreglo de mensualidades 
        // Se actualiza el estado en caso de que la fecha de vencimiento sea anterior a la fecha actual
        foreach ($mensualidades as $mensualidad) {

            if ($mensualidad->fecha_vencimiento && $mensualidad->fecha_vencimiento < $hoy) {
                $mensualidad->estado_pago = 'vencido';
                $mensualidad->save();
            }
        }
    }
}
