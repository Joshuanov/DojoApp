<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Editar Plan Asignado</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto">
        <form action="{{ route('alumno_plan.update', $alumnoPlan) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Select de Alumno con búsqueda -->
                <div>
                    <x-input-label for="alumno_id" value="Alumno" />
                    <select name="alumno_id" id="alumno_id" class="w-full">
                        @foreach($alumnos as $alumno)
                            <option value="{{ $alumno->id }}" {{ $alumnoPlan->alumno_id == $alumno->id ? 'selected' : '' }}>
                                {{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select de Plan con búsqueda -->
                <div>
                    <x-input-label for="plan_id" value="Plan" />
                    <select name="plan_id" id="plan_id" class="w-full">
                        @foreach($planes as $plan)
                            <option value="{{ $plan->id }}" {{ $alumnoPlan->plan_id == $plan->id ? 'selected' : '' }}>
                                {{ $plan->nombre_plan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Campos adicionales -->
                <div>
                    <x-input-label for="fecha_inicio" value="Fecha de Inicio" />
                    <x-text-input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $alumnoPlan->fecha_inicio }}" required />
                </div>

                <div>
                    <x-input-label for="duracion_meses" value="Duración (meses)" />
                    <x-text-input type="number" name="duracion_meses" id="duracion_meses" value="{{ $alumnoPlan->duracion_meses }}" required />
                </div>

                <div>
                    <x-input-label for="estado" value="Estado" />
                    <x-text-input type="text" name="estado" value="{{ $alumnoPlan->estado }}" required />
                </div>

                <div>
                    <x-input-label for="num_cuotas" value="Número de Cuotas" />
                    <x-text-input type="number" name="num_cuotas" value="{{ $alumnoPlan->num_cuotas }}" required />
                </div>

                <div>
                    <x-input-label for="monto_cuota" value="Monto por Cuota" />
                    <x-text-input type="number" name="monto_cuota" value="{{ $alumnoPlan->monto_cuota }}" required />
                </div>

                <div>
                    <x-input-label for="pago_inicial" value="Pago Inicial" />
                    <x-text-input type="number" name="pago_inicial" value="{{ $alumnoPlan->pago_inicial }}" required />
                </div>

                <div>
                    <x-input-label for="meses_congelados" value="Meses Congelados" />
                    <x-text-input type="number" name="meses_congelados" value="{{ $alumnoPlan->meses_congelados }}" required />
                </div>

                <div>
                    <x-input-label for="fecha_fin_real_mostrar" value="Fecha Fin Real (calculada automáticamente)" />
                    <x-text-input type="text" id="fecha_fin_real_mostrar" class="bg-gray-100" readonly />
                </div>

                  {{-- Campo oculto para enviar al backend --}}
                <input type="hidden" name="fecha_fin_real" id="fecha_fin_real"
                    value="{{ $alumnoPlan->fecha_fin_real }}">
            </div>

            <!-- Observaciones -->
            <div>
                <x-input-label for="observaciones" value="Observaciones" />
                <textarea name="observaciones" rows="3" class="w-full border-gray-300 rounded-md">{{ $alumnoPlan->observaciones }}</textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-start mt-6">
                <x-primary-button>Actualizar</x-primary-button>
                <a href="{{ route('alumno_plan.index') }}" class="ml-4">
                    <x-secondary-button>Cancelar</x-secondary-button>
                </a>
            </div>
        </form>
    </div>

    <!-- Scripts para Select2 -->
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#alumno_id').select2({
                placeholder: 'Selecciona un alumno',
                width: '100%'
            });

            $('#plan_id').select2({
                placeholder: 'Selecciona un plan',
                width: '100%'
            });
        });
    </script>
    @endpush
</x-app-layout>
