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
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_plan');
            $table->integer('duracion_meses');
            $table->integer('monto_total');
            $table->integer('monto_base_mensual');
            $table->integer('pago_inicial');
            $table->string('tipo_plan_pago');
            $table->integer('cant_clases_tradicional');
            $table->integer('cant_clases_sanda');
            $table->integer('cant_clases_extra');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
