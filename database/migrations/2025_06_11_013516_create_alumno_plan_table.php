<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumno_plan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('plan_id');
            $table->date('fecha_inicio');
            $table->integer('duracion_meses');
            $table->string('estado');
            $table->integer('num_cuotas');
            $table->integer('monto_cuota');
            $table->integer('pago_inicial');
            $table->string('observaciones')->nullable();
            $table->integer('meses_congelados');
            $table->date('fecha_fin_real');
            $table->timestamps();

            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno_plan');
    }
};
