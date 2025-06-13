<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoPlan extends Model
{
    use HasFactory;

    protected $table = 'alumno_plan';

    protected $fillable = [
        'alumno_id',
        'plan_id',
        'fecha_inicio',
        'duracion_meses',
        'estado',
        'num_cuotas',
        'monto_cuota',
        'pago_inicial',
        'observaciones',
        'meses_congelados',
        'fecha_fin_real',
    ];


    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
