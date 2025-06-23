<?php
/*
Este es un servicio que guarda la lógica para generar las cuotas de planes personalizados. 
Se necesita:
    1. Definir cuántas cuotas se generan.
    2. Establecer las fechas de vencimiento.
    3. Calcular el monto. 
    4. Guardarlas en la tabla mensualidades.
*/

namespace App\Services;

use App\Models\AlumnoPlan;
use App\Models\Mensualidad;
use Illuminate\Support\Carbon;

class GeneradorCuotasService
{
    //Esta función genera una cuota por cada mes, comenzando desde la fecha de inicio del contrato.
    public function generar(AlumnoPlan $alumnoPlan): void
    {
        $fechaInicio = Carbon::parse($alumnoPlan->fecha_inicio); //Carbon::parse convierte texto a objeto fecha
        $montoCuota = $alumnoPlan->monto_cuota;
        $numCuotas = $alumnoPlan->num_cuotas;

        //Creación de cuotas
        for ($i = 1; $i <= $numCuotas; $i++) {
            Mensualidad::create([
                'alumno_plan_id'    => $alumnoPlan->id,
                'nro_cuota'         => $i,
                'monto_cuota'       => $montoCuota,
                'estado_pago'       => 'pendiente',
                'fecha_pago'        => $fechaInicio->copy()->addMonths($i - 1),
                'fecha_vencimiento' => $fechaInicio->copy()->addMonths($i - 1),
                'observaciones'     => null,
            ]);
        }
    }
}