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



    //Mostrar nombre/texto, no clave guardada en bb.dd
    //GRADOS
    public static function grados()
    {
        return 
        [
            'tiger_blanco' => 'Tiger Blanco', 
            'tiger_amarillo' => 'Tiger Amarillo', 
            'tiger_verde' => 'Tiger Verde', 
            'tiger_violeta' => 'Tiger Violeta', 
            'tiger_rojo' => 'Tiger Rojo', 
            'amarillo_jr'=> 'Amarillo Junior', 
            'dorado_jr' => 'Dorado Junior', 
            'naranjo_jr' => 'Naranjo Junior', 
            'jade_jr' => 'Jade Junior', 
            'verde_jr' => 'Verde Junior', 
            'violeta_jr' => 'Violeta Junior', 
            'azul_jr' => 'Azul Junior', 
            'rojo_jr' => 'Rojo Junior', 
            'cafe_jr' => 'Café Junior', 
            'cafe_av_jr' => 'Café av. Junior', 
            'amarillo' =>'Amarillo', 
            'dorado' => 'Dorado', 
            'naranjo' => 'Naranjo', 
            'jade' => 'Jade', 
            'verde' => 'Verde', 
            'violeta' => 'Violeta', 
            'azul' => 'Azul', 
            'rojo' => 'Rojo', 
            'cafe' => 'Café', 
            'cafe_avanzado' => 'Café Avanzado', 
            'negro' => 'Negro', 
            'negro_I' => 'Negro I', 
            'negro_II' => 'Negro II', 
            'negro_III' => 'Negro III'
        ];
    }

    //Cuando se escriba $alumno->grado_nombre, devuelve un valor personalizado en lugar de un campo real de la base de datos
    public function getGradoNombreAttribute()
    {
        //Llama a la función grados y toma el texto asociado a la clave para mostrar
        return self::grados()[$this->grado] ?? this->grado;
    }


    //NIVEL
    public static function niveles()
    {
        return 
        [
            'junior' =>'Junior', 
            'basico' => 'Básico', 
            'intermedio' => 'Intermedio', 
            'avanzado' => 'Avanzado', 
            'faja_negra' => 'Faja Negra', 
            'sanda' => 'Sanda'
        ];
    }

    //Cuando se escriba $alumno->nivel_nombre, devuelve un valor personalizado en lugar de un campo real de la base de datos
    public function getNivelNombreAttribute() //atributo virtual nivel_nombre
    {
        //Llama a la función grados y toma el texto asociado a la clave para mostrar
        return self::niveles()[$this->nivel] ?? this->nivel;
    }

    
    //ESTADO
    public static function estados()
    {
        return 
        [
            'activo'=>'Activo', 
            'congelado' => 'Congelado', 
            'baja' => 'Baja'
        ];
    }

    //Cuando se escriba $alumno->estados_nombre, devuelve un valor personalizado en lugar de un campo real de la base de datos
    public function getEstadoNombreAttribute() //atributo virtual estado_nombre
    {
        //Llama a la función grados y toma el texto asociado a la clave para mostrar
        return self::estados()[$this->estado] ?? this->estado;
    }



}
