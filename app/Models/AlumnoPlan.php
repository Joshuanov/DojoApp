<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoPlan extends Model
{
    use HasFactory;

    protected $table = 'alumno_plan';

    protected $fillable = [
        'alumno_id', //belongsTo
        'plan_id', //belongsTo
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


    // AlumnoPlan contiene clave foranea de Alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    // AlumnoPlan contiene clave foranea de Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
