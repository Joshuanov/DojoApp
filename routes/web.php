<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AlumnoPlanController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('alumnos', AlumnoController::class);
    Route::resource('planes', PlanController::class);
    Route::resource('alumno-plan', AlumnoPlanController::class);
    Route::resource('asistencias', AsistenciaController::class);
    Route::resource('mensualidades', MensualidadController::class);
    Route::resource('tipo-clase', TipoClaseController::class);
});

require __DIR__.'/auth.php';
