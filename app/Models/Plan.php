<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_plan',
        'descripcion',
        'duracion_meses',
        'cuotas',
        'valor_cuota',
        'valor_total',
        'clases_por_semana',
        'dias',
        'observaciones',
    ];

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_plan')->withTimestamps();
    }
} 
