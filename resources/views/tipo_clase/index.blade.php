<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
            Tipos de Clase
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-900">Listado de Tipos de Clase</h1>
            <a href="{{ route('tipo_clase.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Nuevo Tipo de Clase
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded border border-gray-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nombre</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Grupo</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Duración (min)</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($tipos as $tipo)
                        <tr>

                            <td class="px-4 py-2">{{ $tipo->nombre_clase }}</td>
                            <td class="px-4 py-2">{{ $tipo->grupo }}</td>
                            <td class="px-4 py-2">{{ $tipo->duracion }}</td>
                            <td class="px-4 py-2 space-x-2 flex items-center">
                                <a href="{{ route('tipo_clase.edit', $tipo) }}">
                                    <x-secondary-button>Editar</x-secondary-button>
                                </a>

                                <form action="{{ route('tipo_clase.destroy', $tipo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este tipo de clase?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Eliminar</x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                No hay tipos de clase registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
