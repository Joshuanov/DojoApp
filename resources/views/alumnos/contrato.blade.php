<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Contrato {{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }} | Grado: {{$alumno->grado_nombre}} | Nivel/Grupo: {{$alumno->nivel_nombre}} | Contacto: {{ $alumno->contacto }}
        </h2>
    </x-slot>
    <div class="py-4 px-6 dark:text-white">

            <h3 class="text-lg font-bold mb-2">Detalles del Plan Contratado</h3>
    </div>

    <!-- Tabla de detalles del plan contratado-->
    @if($alumno->alumnoPlan && $alumno->alumnoPlan->plan)
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Plan</th>
                        <th class="px-4 py-2 border">Fecha Inicio</th>
                        <th class="px-4 py-2 border">Duración (meses)</th>
                        <th class="px-4 py-2 border">Estado</th>
                        <th class="px-4 py-2 border">Nº Cuota</th>
                        <th class="px-4 py-2 border">Monto Cuota</th>
                        <th class="px-4 py-2 border">Pago Inicial</th>
                        <th class="px-4 py-2 border">Observaciones</th>
                        <th class="px-4 py-2 border">Meses Congelados</th>
                        <th class="px-4 py-2 border">Fecha Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->plan->nombre_plan }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->fecha_inicio }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->duracion_meses }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->estado }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->num_cuotas }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->monto_cuota }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->pago_inicial }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->observaciones }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->meses_congelados }}</td>
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->fecha_fin_real }}</td>
                    </tr>
                </tbody>
            </table>
        </div>


@if(isset($mensualidades) && count($mensualidades))
    <div class="overflow-x-auto mb-6">
        <h3 class="text-lg font-bold mb-2">Cuotas del Plan</h3>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Cuota</th>
                    <th class="px-4 py-2 border">Monto</th>
                    <th class="px-4 py-2 border">Estado</th>
                    <th class="px-4 py-2 border">Pago</th>
                    <th class="px-4 py-2 border">Vencimiento</th>
                    <th class="px-4 py-2 border">Obs.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mensualidades as $mensualidad)
                    <tr>
                        <td class="px-4 py-2 border text-center">{{ $mensualidad->nro_cuota }}</td>
                        <td class="px-4 py-2 border text-right">${{ number_format($mensualidad->monto_cuota, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border capitalize text-center">{{ $mensualidad->estado_pago }}</td>
                        <td class="px-4 py-2 border text-center">
                            {{ $mensualidad->fecha_pago ? \Carbon\Carbon::parse($mensualidad->fecha_pago)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-2 border text-center">
                            {{ $mensualidad->fecha_vencimiento ? \Carbon\Carbon::parse($mensualidad->fecha_vencimiento)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-2 border text-sm text-gray-600">{{ $mensualidad->observaciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-gray-500">No hay mensualidades registradas para este alumno.</p>
@endif

    @else
        <p>No hay plan asignado a este alumno.</p>
    @endif

    <a href="{{ route('alumnos.index') }}">
        <x-secondary-button color="canary" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Volver al listado
        </x-secondary-button>
    </a>

</x-app-layout>


