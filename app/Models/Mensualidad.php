<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensualidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_plan_id',
        'nro_cuota',
        'monto_cuota',
        'estado_pago',
        'fecha_pago',
        'fecha_vencimiento',
        'observaciones',
    ];

    public function alumnoPlan()
    {
        return $this->belongsTo(AlumnoPlan::class);
    }
}
