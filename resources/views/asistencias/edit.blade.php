<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Editar Asistencia
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto">
        <form action="{{ route('asistencias.update', $asistencia) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="alumno_id" class="block font-medium text-sm text-gray-700">Alumno</label>
                <select name="alumno_id" id="alumno_id" class="mt-1 block w-full border-gray-300 rounded">
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id }}" {{ $alumno->id == $asistencia->alumno_id ? 'selected' : '' }}>
                            {{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="fecha" class="block font-medium text-sm text-gray-700">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="{{ $asistencia->fecha }}" class="mt-1 block w-full border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="tipo_clase_id" class="block font-medium text-sm text-gray-700">Tipo de Clase</label>
                <select name="tipo_clase_id" id="tipo_clase_id" class="mt-1 block w-full border-gray-300 rounded">
                    @foreach($tiposClase as $tipo)
                        <option value="{{ $tipo->id }}" {{ $tipo->id == $asistencia->tipo_clase_id ? 'selected' : '' }}>
                            {{ $tipo->nombre_clase }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="estado" class="block font-medium text-sm text-gray-700">Estado</label>
                <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="presente" {{ $asistencia->estado === 'presente' ? 'selected' : '' }}>Presente</option>
                    <option value="ausente" {{ $asistencia->estado === 'ausente' ? 'selected' : '' }}>Ausente</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="comentario" class="block font-medium text-sm text-gray-700">Comentario</label>
                <textarea name="comentario" id="comentario" class="mt-1 block w-full border-gray-300 rounded">{{ $asistencia->comentario }}</textarea>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="es_recuperacion" class="rounded border-gray-300" value="1" {{ $asistencia->es_recuperacion ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600">Es clase de recuperación</span>
                </label>
            </div>

            <button type="submit"
                class="mt-4 px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                Guardar Cambios
            </button>
        </form>
    </div>
</x-app-layout>
