<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Listado de Planes
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <div class="flex justify-start mb-4">
            <a href="{{ route('planes.create') }}">
                <x-primary-button>Registrar Plan</x-primary-button>
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="mb-4">
            <input type="text" name="busqueda" value="{{ request('busqueda') }}" placeholder="Buscar..."
                class="border border-gray-300 rounded-md px-4 py-2 w-full md:w-1/3">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Buscar
            </button>
        </form>


        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded shadow-sm text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Nombre Plan</th>
                        <th class="px-4 py-2">Duración (meses)</th>
                        <th class="px-4 py-2">Monto Total</th>
                        <th class="px-4 py-2">Monto Base Mensual</th>
                        <th class="px-4 py-2">Pago Inicial</th>
                        <th class="px-4 py-2">Tipo de Pago</th>
                        <th class="px-4 py-2">Clases Tradicional</th>
                        <th class="px-4 py-2">Clases Sanda</th>
                        <th class="px-4 py-2">Clases Extra</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planes as $plan)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $plan->nombre_plan }}</td>
                            <td class="px-4 py-2">{{ $plan->duracion_meses }}</td>
                            <td class="px-4 py-2">{{ $plan->monto_total }}</td>
                            <td class="px-4 py-2">{{ $plan->monto_base_mensual }}</td>
                            <td class="px-4 py-2">{{ $plan->pago_inicial }}</td>
                            <td class="px-4 py-2">{{ $plan->tipo_plan_pago }}</td>
                            <td class="px-4 py-2">{{ $plan->cant_clases_tradicional }}</td>
                            <td class="px-4 py-2">{{ $plan->cant_clases_sanda }}</td>
                            <td class="px-4 py-2">{{ $plan->cant_clases_extra }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <a href="{{ route('planes.edit', $plan) }}">
                                    <x-secondary-button>Editar</x-secondary-button>
                                </a>
                                <form action="{{ route('planes.destroy', $plan) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este plan?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Eliminar</x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($planes->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">No hay planes registrados.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
