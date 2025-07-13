<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
            Contrato
        </h1>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
             Alumno: {{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }} || Grado: {{$alumno->grado_nombre}} || Nivel/Grupo: {{$alumno->nivel_nombre}} || Contacto: {{ $alumno->contacto }}
        </h2>
    </x-slot>
    <div class="py-4 px-6 dark:text-white">

            <h3 class="text-lg font-bold mb-2">Detalles del Plan Contratado</h3>
    </div>

    <!--TABLA DE DETALLES DEL PLAN -->
    @if($alumno->alumnoPlan && $alumno->alumnoPlan->plan)
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border">
                
                <thead>
                    <!-- Cabecera de la tabla -->
    
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

                <!-- Cuerpo de la tabla -->
                <tbody>
                    <tr class="text-center">
                        <!-- Nombre del Plan -->
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->plan->nombre_plan }}</td>
                        <!-- Fecha de Inicio -->
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->fecha_inicio }}</td>
                        <!--Duración en meses -->
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->duracion_meses }}</td>
                        <!-- Estado del Plan -->
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->estado }}</td>
                        <!-- Número de Cuotas -->
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->num_cuotas }}</td>
                        <!-- Monto de la Cuota -->
                        <td class="px-4 py-2 border">${{ number_format($alumno->alumnoPlan->monto_cuota, 0, ',', '.') }}</td>
                        <!--Pago Inicial -->
                        <td class="px-4 py-2 border">${{ number_format($alumno->alumnoPlan->pago_inicial, 0, ',', '.') }}</td>
                        <!-- Observaciones -->
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->observaciones }}</td>
                        <!-- Meses Congelados -->
                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->meses_congelados }}</td>
                        <!-- Fecha de Fin de Plan -->

                        <td class="px-4 py-2 border">{{ $alumno->alumnoPlan->fecha_fin_real }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    <!-- TABLA DE MENSUALIDADES DEL PLAN -->
    @if(isset($mensualidades) && count($mensualidades))
        <div class="overflow-x-auto mb-6 ">
            <h3 class="text-lg font-bold mb-2 dark:text-white">Cuotas del Plan</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <!-- Cabecera de la tabla -->
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Cuota</th>
                            <th class="px-4 py-2 border">Monto</th>
                            <th class="px-4 py-2 border">Estado</th>
                            <th class="px-4 py-2 border">Día de pago</th>
                            <th class="px-4 py-2 border">Vencimiento (+1 semana)</th>
                            <th class="px-4 py-2 border">Obs.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Cuerpo de la tabla -->
                        @foreach ($mensualidades as $mensualidad)
                            <tr>
                                <!-- Número de Cuota -->
                                <td class="px-4 py-2 border text-center">{{ $mensualidad->nro_cuota }}</td>
                                <!-- Monto de la Cuota -->
                                <td class="px-4 py-2 border text-right">${{ number_format($mensualidad->monto_cuota, 0, ',', '.') }}</td>
                                <!-- Estado del Pago -->
                                <td class="px-4 py-2 border capitalize text-center">
                                    
                                     @php
                                        $colorClass = match($mensualidad->estado_pago) {
                                            'pagado' => 'bg-green-700 text-white',
                                            'pendiente' => 'bg-yellow-500 text-white',
                                            'vencido' => 'bg-red-600 text-white',
                                            'liberado' => 'bg-white text-black',
                                            default => ''
                                        };
                                    @endphp
                                    
                                    <span class="rounded px-7 py-1 {{ $colorClass }}">
                                        {{ $mensualidad->estado_pago }}
                                    </span>
                                </td>

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


