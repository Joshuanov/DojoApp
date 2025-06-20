<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            Registro de Asistencias
        </h2>

    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('asistencias.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Nueva Asistencia
            </a>
        </div>

        <div class="bg-white shadow-sm rounded border border-gray-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-left text-sm text-gray-700">
                    <tr>

                        <th class="px-4 py-2">Alumno</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Tipo de Clase</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Recup.</th>
                        <th class="px-4 py-2">Comentario</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($asistencias as $asistencia)
                        <tr>

                            <td class="px-4 py-2"> {{ $asistencia->alumno->nombre_alumno }}
                                {{ $asistencia->alumno->apellido_paterno }}
                                {{ $asistencia->alumno->apellido_materno ?? '' }} </td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $asistencia->tipoClase->nombre_clase ?? '-' }}</td>
                            <td class="px-4 py-2 capitalize">{{ $asistencia->estado }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ $asistencia->es_recuperacion ? '✔' : '' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $asistencia->comentario }}</td>
                            <td class="px-4 py-2 space-x-2 flex items-center">
                                <a href="{{ route('asistencias.edit', $asistencia) }}">
                                    <x-secondary-button>Editar</x-secondary-button>
                                </a>

                                <form action="{{ route('asistencias.destroy', $asistencia) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar esta asistencia?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Eliminar</x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">
                                No hay asistencias registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $asistencias->links() }}
        </div>
        <div class="mb-4">
            <a href="{{ route('asistencias.masiva') }}"
                class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                Tomar Asistencia Masiva
            </a>
        </div>

    </div>
</x-app-layout>
