<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'planes';

    protected $fillable = [
        'nombre_plan',
        'duracion_meses',
        'monto_total',
        'monto_base_mensual',
        'pago_inicial',
        'tipo_plan_pago',
        'cant_clases_tradicional',
        'cant_clases_sanda',
        'cant_clases_extra',
    ];

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_plan')->withTimestamps();
    }

    public function alumnoPlanes()
    {
        return $this->hasMany(AlumnoPlan::class);
    }
}
