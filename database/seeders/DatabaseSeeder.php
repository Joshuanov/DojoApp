<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tabla: alumnos
        DB::table('alumnos')->insert([
            [
                'nombre_alumno' => 'Juan',
                'apellido_paterno' => 'Pérez',
                'apellido_materno' => 'Gómez',
                'edad' => 15,
                'rut' => '12345678-9',
                'nivel' => 'Intermedio',
                'grado' => 'Rojo',
                'estado' => 'activo',
                'contacto' => 'juan@example.com',
                'comentario' => 'Alumno nuevo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Tabla: planes
        DB::table('planes')->insert([
            [
                'nombre_plan' => 'Plan Básico',
                'duracion_meses' => 3,
                'monto_total' => 60000,
                'monto_base_mensual' => 20000,
                'pago_inicial' => 20000,
                'tipo_plan_pago' => 'mensual',
                'cant_clases_tradicional' => 4,
                'cant_clases_sanda' => 2,
                'cant_clases_extra' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Tabla: tipo_clase
        DB::table('tipo_clase')->insert([
            [
                'nombre_clase' => 'Tradicional',
                'descripcion' => 'Clase de formas y técnicas',
                'duracion' => 60,
                'grupo' => 'A',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Tabla: alumno_plan
        DB::table('alumno_plan')->insert([
            [
                'alumno_id' => 1,
                'plan_id' => 1,
                'fecha_inicio' => Carbon::now()->subMonths(1),
                'duracion_meses' => 3,
                'estado' => 'activo',
                'num_cuotas' => 3,
                'monto_cuota' => 20000,
                'pago_inicial' => 20000,
                'observaciones' => 'Contrato firmado',
                'meses_congelados' => 0,
                'fecha_fin_real' => Carbon::now()->addMonths(2),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Tabla: asistencias
        DB::table('asistencias')->insert([
            [
                'alumno_id' => 1,
                'fecha' => Carbon::now()->subDays(2),
                'tipo_clase_id' => 1,
                'estado' => 'presente',
                'comentario' => 'Asistió puntual',
                'es_recuperacion' => false,
                'created_at' => now(),
            ]
        ]);

        // Tabla: mensualidades
        DB::table('mensualidades')->insert([
            [
                'alumno_plan_id' => 1,
                'nro_cuota' => 1,
                'monto_cuota' => 20000,
                'estado_pago' => 'pagado',
                'fecha_pago' => Carbon::now()->subDays(10),
                'fecha_vencimiento' => Carbon::now()->subDays(5),
                'observaciones' => 'Pagado en efectivo',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
