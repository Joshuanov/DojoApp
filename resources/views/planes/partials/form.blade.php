<div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-4">
    <div>
        <x-input-label for="nombre_plan" value="Nombre del Plan" />
        <x-text-input id="nombre_plan" name="nombre_plan" type="text" :value="old('nombre_plan', $plan->nombre_plan ?? '')" required autofocus />
    </div>

    <div>
        <x-input-label for="duracion_meses" value="Duración (meses)" />
        <x-text-input id="duracion_meses" name="duracion_meses" type="number" step="1" :value="old('duracion_meses', $plan->duracion_meses ?? '')" required />
    </div>

    <div>
        <x-input-label for="monto_total" value="Monto Total" />
        <x-text-input id="monto_total" name="monto_total" type="number" step="1" :value="old('monto_total', $plan->monto_total ?? '')" required />
    </div>

    <div>
        <x-input-label for="monto_base_mensual" value="Monto Base Mensual" />
        <x-text-input id="monto_base_mensual" name="monto_base_mensual" type="number" step="1" :value="old('monto_base_mensual', $plan->monto_base_mensual ?? '')" required />
    </div>

    <div>
        <x-input-label for="pago_inicial" value="Pago Inicial" />
        <x-text-input id="pago_inicial" name="pago_inicial" type="number" step="1" :value="old('pago_inicial', $plan->pago_inicial ?? '')" required />
    </div>

    <div>
        <x-input-label for="tipo_plan_pago" value="Tipo de Plan de Pago" />
        <x-text-input id="tipo_plan_pago" name="tipo_plan_pago" type="text" :value="old('tipo_plan_pago', $plan->tipo_plan_pago ?? '')" required />
    </div>

    <div>
        <x-input-label for="cant_clases_tradicional" value="Clases Tradicionales por Semana" />
        <x-text-input id="cant_clases_tradicional" name="cant_clases_tradicional" type="number" step="1" :value="old('cant_clases_tradicional', $plan->cant_clases_tradicional ?? '')" required />
    </div>

    <div>
        <x-input-label for="cant_clases_sanda" value="Clases Sanda por Semana" />
        <x-text-input id="cant_clases_sanda" name="cant_clases_sanda" type="number" step="1" :value="old('cant_clases_sanda', $plan->cant_clases_sanda ?? '')" required />
    </div>

    <div>
        <x-input-label for="cant_clases_extra" value="Clases Extra por Semana" />
        <x-text-input id="cant_clases_extra" name="cant_clases_extra" type="number" step="1" :value="old('cant_clases_extra', $plan->cant_clases_extra ?? '')" required />
    </div>
</div>
