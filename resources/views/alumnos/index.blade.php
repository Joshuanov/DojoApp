<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Listado de Alumnos</h2>
    </x-slot>

    <!--BOTON CREAR NUEVO ALUMNO-->
    <div class="py-4 px-6">
        <a href="{{ route('alumnos.create') }}"
            class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Nuevo Alumno</a>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="mb-4">
            <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                placeholder="Buscar por nombre de alumno "
                class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-1/3">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Buscar
            </button>
        </form>


        <table class="min-w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Plan</th>
                    <th class="px-4 py-2">Nivel</th>
                    <th class="px-4 py-2">Grado</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $alumno)
                    <tr>
                        <td class="border px-4 py-2">{{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }}
                            {{ $alumno->apellido_materno }}</td>
                        <td class="border px-4 py-2">{{ $alumno->alumnoPlan->plan->nombre_plan ?? 'Sin plan asignado' }}</td>
                        <td class="border px-4 py-2">{{ $alumno->nivel_nombre }}</td>
                        <td class="border px-4 py-2">{{ $alumno->grado_nombre }}</td>
                        <td class="border px-4 py-2">{{ $alumno->estado_nombre}}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <a href="{{ route('alumnos.edit', $alumno) }}">
                                <x-secondary-button>Editar</x-secondary-button>
                            </a>
                            <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar alumno?');">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>Eliminar</x-danger-button>
                            </form>
                        </td>
                    </tr>
            
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if ($alumnos->hasPages())
            <div class="mt-4">
                {{ $alumnos->links() }}
            </div>
        @else
            <p class="text-sm text-gray-500 mt-4">No hay suficientes resultados para paginar.</p>
        @endif

    </div>
</x-app-layout>
