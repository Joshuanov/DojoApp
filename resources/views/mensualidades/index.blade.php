<x-app-layout>
    <div x-data="modalPagos()">
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

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-2">
                    {{ session('error') }}
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
                            {{-- <th class="px-4 py-2">Monto</th> --}}
                            {{-- <th class="px-4 py-2">Estado</th> --}}
                            {{-- <th class="px-4 py-2">Pago</th>
                        <th class="px-4 py-2">Vencimiento</th>
                        <th class="px-4 py-2">Obs.</th> --}}
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">



                        {{-- @forelse ($mensualidades as $mensualidad)
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
                    @endforelse --}}

                        @forelse ($alumnosConContrato as $alumno)
                            <tr class="border-b">
                                <td class="px-4 py-2 font-semibold">{{ $alumno->nombre_alumno }}
                                    {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</td>

                                <td class="px-4 py-2 text-center">
                                    {{ $alumno->alumnoPlan?->plan?->nombre_plan ?? 'Sin plan' }}
                                </td>

                                <td class="px-4 py-2 text-center">
                                    {{ $alumno->mensualidades->where('estado_pago', 'pendiente')->count() }} pendientes
                                </td>

                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ route('mensualidades.edit', $alumno->id) }}"
                                        class="px-2 py-1 text-sm bg-blue-500 text-white rounded">Editar</a>
                                    <form action="{{ route('mensualidades.destroy', $alumno->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-sm bg-red-500 text-white rounded"
                                            onclick="return confirm('¿Seguro?')">Eliminar</button>
                                    </form>

                                    <!-- Botón para abrir modal -->
                                    <button @click="openModal({{ $alumno->id }})"
                                        class="px-2 py-1 text-sm bg-green-500 text-white rounded">Pagar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No hay alumnos con contratos activos.</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>




            </div>

            <div class="mt-4">
                {{ $alumnosConContrato->links() }}
            </div>
        </div>



        <script>
            function modalPagos() {
                return {
                    showModal: false,
                    alumnoId: null,
                    openModal(id) {
                        this.alumnoId = id;
                        this.showModal = true;
                    }
                }
            }
        </script>

        <!-- MODAL -->
        <div x-show="showModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white p-6 rounded shadow-md w-full max-w-lg" @click.outside="showModal = false">
                <h2 class="text-lg font-bold mb-4">Selecciona cuotas a pagar</h2>

                <form method="POST" action="{{ route('mensualidades.pagar') }}">
                    @csrf
                    <input type="hidden" name="alumno_id" :value="alumnoId">

                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach ($mensualidades as $cuota)
                            <template
                                x-if="alumnoId == {{ $cuota->alumnoPlan->alumno_id }} && '{{ $cuota->estado_pago }}' == 'pendiente'">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="cuotas[]" value="{{ $cuota->id }}">
                                    <span>
                                        Cuota {{ $cuota->nro_cuota }} -
                                        {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}
                                        - ${{ number_format($cuota->monto_cuota, 0, ',', '.') }}
                                    </span>
                                </label>
                            </template>
                        @endforeach
                    </div>

                    <div class="mt-4 text-right space-x-2">
                        <button type="button" @click="showModal = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Confirmar pago</button>
                    </div>
                </form>
            </div>
        </div>



    </div>
</x-app-layout>
