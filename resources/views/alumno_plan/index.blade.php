<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Planes Contratados por Alumnos
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        @if (session('success'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('alumno_plan.create') }}">
                <x-primary-button>Asignar Nuevo Plan</x-primary-button>
            </a>
        </div>

        <form method="GET" class="mb-4">
            <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                placeholder="Buscar por alumno, plan, estado o fecha..."
                class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-1/3">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Buscar
            </button>
        </form>


        <div class="overflow-x-auto">
            <table class="min-w-full bg-white white:bg-gray-800 border">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Alumno</th>
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
                        <th class="px-4 py-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnosPlanes as $item)
                        <tr>
                            <td class="px-4 py-2 border">{{ $item->alumno->nombre_alumno }}
                                {{ $item->alumno->apellido_paterno }} {{ $item->alumno->apellido_materno }}</td>
                            <td class="px-4 py-2 border">{{ $item->plan->nombre_plan }}</td>
                            <td class="px-4 py-2 border">{{ $item->fecha_inicio }}</td>
                            <td class="px-4 py-2 border">{{ $item->duracion_meses }}</td>
                            <td class="px-4 py-2 border">{{ $item->estado }}</td>
                            <td class="px-4 py-2 border">{{ $item->num_cuotas }}</td>
                            <td class="px-4 py-2 border">{{ $item->monto_cuota }}</td>
                            <td class="px-4 py-2 border">{{ $item->pago_inicial }}</td>
                            <td class="px-4 py-2 border">{{ $item->observaciones }}</td>
                            <td class="px-4 py-2 border">{{ $item->meses_congelados }}</td>
                            <td class="px-4 py-2 border">{{ $item->fecha_fin_real }}</td>
                            <td class="px-4 py-2 border flex gap-2">
                                <a href="{{ route('alumno_plan.edit', $item) }}">
                                    <x-secondary-button>Editar</x-secondary-button>
                                </a>
                                <form action="{{ route('alumno_plan.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Confirmar eliminación?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Eliminar</x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $alumnosPlanes->links() }}
        </div>
    </div>
</x-app-layout>
