<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plan;
use App\Models\Alumno;
use App\Models\AlumnoPlan;
use App\Models\Mensualidad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class DashboardNotificationTest extends TestCase
{
    use RefreshDatabase;

    private function crearDatosBasicos()
    {
        $plan = Plan::create([
            'nombre_plan' => 'Plan Test',
            'duracion_meses' => 1,
            'monto_total' => 1000,
            'monto_base_mensual' => 1000,
            'pago_inicial' => 0,
            'tipo_plan_pago' => 'mensual',
            'cant_clases_tradicional' => 0,
            'cant_clases_sanda' => 0,
            'cant_clases_extra' => 0,
        ]);

        $alumno = Alumno::create([
            'nombre_alumno' => 'Juan',
            'apellido_paterno' => 'Perez',
            'apellido_materno' => 'Gomez',
            'edad' => 20,
            'rut' => '12345678-9',
            'nivel' => 'basico',
            'grado' => 'amarillo',
            'estado' => 'activo',
            'contacto' => '123456789',
        ]);

        return AlumnoPlan::create([
            'alumno_id' => $alumno->id,
            'plan_id' => $plan->id,
            'fecha_inicio' => Carbon::now(),
            'duracion_meses' => 1,
            'estado' => 'activo',
            'num_cuotas' => 1,
            'monto_cuota' => 1000,
            'pago_inicial' => 0,
            'observaciones' => null,
            'meses_congelados' => 0,
            'fecha_fin_real' => Carbon::now()->addMonth(),
        ]);
    }

    public function test_dashboard_calculates_new_overdue_quotas()
    {
        $user = User::factory()->create([
            'vencidos_checked_at' => Carbon::now()->subDays(2),
        ]);
        $this->actingAs($user);

        $alumnoPlan = $this->crearDatosBasicos();

        Mensualidad::create([
            'alumno_plan_id' => $alumnoPlan->id,
            'nro_cuota' => 1,
            'monto_cuota' => 1000,
            'estado_pago' => 'vencido',
            'fecha_pago' => Carbon::now(),
            'fecha_vencimiento' => Carbon::now()->subDay(), // venció después del último check
        ]);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertViewHas('nuevasCuotas', 1);
    }

    public function test_reviewing_vencidos_resets_counter()
    {
        $user = User::factory()->create([
            'vencidos_checked_at' => Carbon::now()->subDays(2),
        ]);
        $this->actingAs($user);

        $alumnoPlan = $this->crearDatosBasicos();

        Mensualidad::create([
            'alumno_plan_id' => $alumnoPlan->id,
            'nro_cuota' => 1,
            'monto_cuota' => 1000,
            'estado_pago' => 'vencido',
            'fecha_pago' => Carbon::now(),
            'fecha_vencimiento' => Carbon::now()->subDay(),
        ]);

        // Verifica que aparezca la notificación
        $this->get('/dashboard')->assertViewHas('nuevasCuotas', 1);

        // Al ingresar a /alumnos/vencidos se actualiza la revisión
        $this->get('/alumnos/vencidos')->assertStatus(200);
        $this->assertNotNull($user->fresh()->vencidos_checked_at);

        // Ya no deberían haber cuotas nuevas
        $this->get('/dashboard')->assertViewHas('nuevasCuotas', 0);
    }
}
