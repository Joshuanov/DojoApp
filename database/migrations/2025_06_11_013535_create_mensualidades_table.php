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
        Schema::create('mensualidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_plan_id');
            $table->integer('nro_cuota');
            $table->integer('monto_cuota');
            $table->string('estado_pago');
            $table->date('fecha_pago');
            $table->date('fecha_vencimiento');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('alumno_plan_id')->references('id')->on('alumno_plan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensualidades');
    }
};
