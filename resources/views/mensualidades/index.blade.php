<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Listado de Mensualidades
        </h2>
    </x-slot>

    <div class="py-4 px-6 max-w-7xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('mensualidades.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Nueva Mensualidad
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded shadow border">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-sm text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">Alumno</th>
                        <th class="px-4 py-2 text-left">Plan</th>
                        <th class="px-4 py-2">Cuota</th>
                        <th class="px-4 py-2">Monto</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Pago</th>
                        <th class="px-4 py-2">Vencimiento</th>
                        <th class="px-4 py-2">Obs.</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($mensualidades as $mensualidad)
                        <tr>
                            <td class="px-4 py-2">
                                {{ $mensualidad->alumnoPlan->alumno->nombre_alumno }}
                                {{ $mensualidad->alumnoPlan->alumno->apellido_paterno }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $mensualidad->alumnoPlan->plan->nombre_plan ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-center">{{ $mensualidad->nro_cuota }}</td>
                            <td class="px-4 py-2 text-right">${{ number_format($mensualidad->monto_cuota, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 capitalize text-center">{{ $mensualidad->estado_pago }}</td>
                            <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($mensualidad->fecha_pago)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($mensualidad->fecha_vencimiento)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $mensualidad->observaciones }}</td>
                            <td class="px-4 py-2 space-x-2 flex items-center">
                                <a href="{{ route('mensualidades.edit', $mensualidad->id) }}">
                                    <x-secondary-button>Editar</x-secondary-button>
                                </a>
                                <form action="{{ route('mensualidades.destroy', $mensualidad) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar esta mensualidad?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Eliminar</x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-4 text-center text-gray-500">
                                No hay mensualidades registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $mensualidades->links() }}
        </div>
    </div>
</x-app-layout>
