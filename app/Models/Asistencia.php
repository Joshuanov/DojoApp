<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'fecha',
        'tipo_clase_id',
        'estado',
        'comentario',
        'es_recuperacion',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function tipoClase()
    {
        return $this->belongsTo(TipoClase::class);
    }
}
