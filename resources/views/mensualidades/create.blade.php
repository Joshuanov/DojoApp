<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Registrar Mensualidad</h2>
    </x-slot>

    <div class="py-4 px-6 max-w-5xl mx-auto">
        <form action="{{ route('mensualidades.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf

            {{-- Alumno / Plan --}}
            <div class="col-span-1 md:col-span-2">
                <label for="alumno_plan_id" class="block text-sm font-medium text-gray-700">Alumno / Plan</label>
                <select name="alumno_plan_id" id="select-alumno-plan" required
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">Seleccione un alumno</option>
                    @foreach ($alumnoPlanes as $ap)
                        <option value="{{ $ap->id }}">
                            {{ $ap->alumno->nombre_alumno }} {{ $ap->alumno->apellido_paterno }}
                            - {{ $ap->plan->nombre_plan ?? 'Plan N/A' }}
                        </option>
                    @endforeach
                </select>

            </div>

            {{-- Número de Cuota --}}
            <div>
                <label for="nro_cuota" class="block text-sm font-medium text-gray-700">N° Cuota</label>
                <input type="number" name="nro_cuota" id="nro_cuota" min="1" required
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>

            {{-- Monto --}}
            <div>
                <label for="monto_cuota" class="block text-sm font-medium text-gray-700">Monto</label>
                <input type="number" name="monto_cuota" id="monto_cuota" min="0" required
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>

            {{-- Estado de Pago --}}
            <div>
                <label for="estado_pago" class="block text-sm font-medium text-gray-700">Estado de Pago</label>
                <select name="estado_pago" id="estado_pago" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="pendiente">Pendiente</option>
                    <option value="pagado">Pagado</option>
                    <option value="atrasado">Atrasado</option>
                </select>
            </div>

            {{-- Fecha de Pago --}}
            <div>
                <label for="fecha_pago" class="block text-sm font-medium text-gray-700">Fecha de Pago</label>
                <input type="date" name="fecha_pago" id="fecha_pago"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>

            {{-- Fecha de Vencimiento --}}
            <div>
                <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700">Fecha de
                    Vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>

            {{-- Observaciones --}}
            <div class="md:col-span-2">
                <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm"></textarea>
            </div>

            <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                <a href="{{ route('mensualidades.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    Volver
                </a>

                <x-primary-button>Guardar</x-primary-button>
            </div>




        </form>
    </div>
</x-app-layout>
