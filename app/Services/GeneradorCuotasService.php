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
    // Esta función recibe un objeto AlumnoPlan y una lista de cuotas
    public function generar(AlumnoPlan $alumnoPlan, array $cuotasList): void
    {
        foreach ($cuotasList as $i => $cuota) {
            Mensualidad::create([
                'alumno_plan_id'    => $alumnoPlan->id,
                'nro_cuota'         => $i + 1,
                'monto_cuota'       => $cuota['monto'],
                'estado_pago'       => $cuota['monto'] == 0 ? 'liberado' : 'pendiente',
                'fecha_pago'        => $cuota['fecha'],
                'fecha_vencimiento' => Carbon::parse($cuota['fecha'])->addDays(7),
                'observaciones'     => null,
            ]);
        }
    }
}