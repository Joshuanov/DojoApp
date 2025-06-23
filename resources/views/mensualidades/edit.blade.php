<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Editar Mensualidad
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto">
        <form action="{{ route('mensualidades.update', $mensualidad) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="alumno_plan_id" class="block font-medium text-sm text-gray-700">Alumno / Plan</label>
                <select name="alumno_plan_id" id="alumno_plan_id" class="mt-1 block w-full border-gray-300 rounded">
                    @foreach($alumnoPlanes as $ap)
                        <option value="{{ $ap->id }}" {{ $ap->id == $mensualidad->alumno_plan_id ? 'selected' : '' }}>
                            {{ $ap->alumno->nombre_alumno }} {{ $ap->alumno->apellido_paterno }} - {{ $ap->plan->nombre_plan ?? 'Plan N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="nro_cuota" class="block font-medium text-sm text-gray-700">Número de Cuota</label>
                <input type="number" name="nro_cuota" id="nro_cuota" value="{{ $mensualidad->nro_cuota }}"
                       class="mt-1 block w-full border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="monto_cuota" class="block font-medium text-sm text-gray-700">Monto</label>
                <input type="number" name="monto_cuota" id="monto_cuota" value="{{ $mensualidad->monto_cuota }}"
                       class="mt-1 block w-full border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="estado_pago" class="block font-medium text-sm text-gray-700">Estado de Pago</label>
                <select name="estado_pago" id="estado_pago" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="pendiente" {{ $mensualidad->estado_pago == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="pagado" {{ $mensualidad->estado_pago == 'pagado' ? 'selected' : '' }}>Pagado</option>
                    <option value="atrasado" {{ $mensualidad->estado_pago == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="fecha_pago" class="block font-medium text-sm text-gray-700">Fecha de Pago</label>
                <input type="date" name="fecha_pago" id="fecha_pago" value="{{ $mensualidad->fecha_pago }}"
                       class="mt-1 block w-full border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="fecha_vencimiento" class="block font-medium text-sm text-gray-700">Fecha de Vencimiento</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ $mensualidad->fecha_vencimiento }}"
                       class="mt-1 block w-full border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="observaciones" class="block font-medium text-sm text-gray-700">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded">{{ $mensualidad->observaciones }}</textarea>
            </div>

            <button type="submit"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                Guardar Cambios
            </button>
        </form>
    </div>
</x-app-layout>
