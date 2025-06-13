<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_alumno',
        'apellido_paterno',
        'apellido_materno',
        'edad',
        'rut',
        'nivel',
        'grado',
        'estado',
        'contacto',
        'comentario',
    ];

    // Un alumno puede tener muchos planes (relación muchos a muchos)
    public function planes()
    {
        return $this->belongsToMany(Plan::class, 'alumno_plan')->withTimestamps();
    }

    // Un alumno puede tener muchas asistencias
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Un alumno puede tener muchas mensualidades
    public function mensualidades()
    {
        return $this->hasMany(Mensualidad::class);
    }
}
