<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Asignar Plan a Alumno</h2>
    </x-slot>


    <div class="py-6 px-4 max-w-3xl mx-auto">

        <form action="{{ route('alumno_plan.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <x-input-label for="alumno_id" value="Alumno" />
                    <select name="alumno_id" id="alumno_id" class="w-full border-gray-300 rounded-md">
                        <option value="">-- Selecciona un alumno --</option>
                        @foreach ($alumnos as $alumno)
                            <option value="{{ $alumno->id }}">
                                {{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }}
                                {{ $alumno->apellido_materno }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="plan_id" value="Plan" />
                    <select name="plan_id" id="plan_id" class="w-full border-gray-300 rounded-md">
                        @foreach ($planes as $plan)
                            <option value="{{ $plan->id }}">
                                {{ $plan->nombre_plan }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <x-input-label for="fecha_inicio" value="Fecha de Inicio" />
                    <x-text-input type="date" name="fecha_inicio" id="fecha_inicio" required />
                </div>

                <div>
                    <x-input-label for="duracion_meses" value="Duración (meses)" />
                    <x-text-input type="number" name="duracion_meses" id="duracion_meses" required />
                </div>

                <div>
                    <x-input-label for="estado" value="Estado" />
                    <x-text-input type="text" name="estado" required />
                </div>

                <div>
                    <x-input-label for="num_cuotas" value="Número de Cuotas" />
                    <x-text-input type="number" name="num_cuotas" required />
                </div>

                <div>
                    <x-input-label for="monto_cuota" value="Monto por Cuota" />
                    <x-text-input type="number" name="monto_cuota" required />
                </div>

                <div>
                    <x-input-label for="pago_inicial" value="Pago Inicial" />
                    <x-text-input type="number" name="pago_inicial" required />
                </div>

                <div>
                    <x-input-label for="meses_congelados" value="Meses Congelados" />
                    <x-text-input type="number" name="meses_congelados" required />
                </div>

                 {{-- Campo calculado automáticamente --}}
                <div>
                    <x-input-label for="fecha_fin_real" value="Fecha Fin Real (calculada automáticamente)" />
                    <x-text-input type="text" id="fecha_fin_real" class="bg-gray-100" readonly />
                </div>
            </div>

            <div>
                <x-input-label for="observaciones" value="Observaciones" />
                <textarea name="observaciones" rows="3" class="w-full border-gray-300 rounded-md"></textarea>
            </div>

            <div class="flex justify-start mt-6">
                <x-primary-button>Guardar</x-primary-button>
                <a href="{{ route('alumno_plan.index') }}" class="ml-4">
                    <x-secondary-button>Cancelar</x-secondary-button>
                </a>
            </div>
        </form>
    </div>

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


</x-app-layout>
