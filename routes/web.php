<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AlumnoPlanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\MensualidadController;
use App\Http\Controllers\TipoClaseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para ver alumnos con cuotas vencidas
    Route::get('/alumnos/vencidos', [AlumnoController::class, 'alumnosConCuotasVencidas'])->name('alumnos.vencidos');

    Route::post('/mensualidades/pagar', [MensualidadController::class, 'pagar'])->name('mensualidades.pagar');

    Route::get('/asistencias/masiva', [AsistenciaController::class, 'vistaMasiva'])->name('asistencias.masiva');
    Route::post('/asistencias/masiva', [AsistenciaController::class, 'guardarMasiva'])->name('asistencias.masiva.store');

    // Listado semanal de asistencia por alumno
    Route::get('/asistencia', [AsistenciaController::class, 'listadoAlumnos'])->name('asistencia.listado');
    Route::post('/asistencia/increment', [AsistenciaController::class, 'increment'])->name('asistencia.increment');
    Route::post('/asistencia/guardar', [AsistenciaController::class, 'guardarCambios'])->name('asistencia.guardar');

    Route::resource('alumnos', AlumnoController::class);
    Route::resource('planes', PlanController::class)->parameters(['planes' => 'plan']);
    Route::resource('alumno_plan', AlumnoPlanController::class);
    Route::resource('asistencias', AsistenciaController::class);
    Route::resource('mensualidades', MensualidadController::class)->parameters([
        'mensualidades' => 'mensualidad',
    ]);


    Route::resource('tipo_clase', TipoClaseController::class);
    
    // Rutas para la gestión de contratos de alumnos desde lista de alumnos
    Route::get('/alumnos/{alumno}/contrato', [AlumnoController::class, 'verContrato'])->name('alumnos.contrato');

    // Rutas para la gestión de mensualidades desde el contrato del alumno
    Route::patch('/mensualidad/{id}/estado', [MensualidadController::class, 'updateEstado'])->name('mensualidad.updateEstado');

    

});

require __DIR__ . '/auth.php';
