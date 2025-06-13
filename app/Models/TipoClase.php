<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoClase extends Model
{
    use HasFactory;

    protected $table = 'tipo_clase';

    protected $fillable = [
        'nombre_clase',
        'descripcion',
        'duracion',
        'grupo',
    ];

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}
