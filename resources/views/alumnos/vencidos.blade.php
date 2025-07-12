{{-- recursos/views/alumnos/vencidos.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Alumnos con cuotas vencidas</h2>
    </x-slot>

    <div class="py-4 px-6 dark:text-white">
        @forelse($alumnos as $alumno)
        <!-- Se muestra alumno con cuotas vencidas -->
            <div class="mb-4 p-4 border rounded">
                <!-- Nombre y apellido alumno -->
                <strong>{{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</strong>
                <ul>
                    <!-- Lista de cuotas vencidas -->
                    @foreach($alumno->alumnoPlan->mensualidades as $cuota)
                        <li>
                            Cuota nro #{{ $cuota->nro_cuota }} - Vencida el {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                        </li>
                    @endforeach
                </ul>

            </div>
        @empty
            <p class="dark:text-white">No hay alumnos con cuotas vencidas.</p>
        @endforelse
    </div>
</x-app-layout>


