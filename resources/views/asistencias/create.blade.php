<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Registrar Asistencia
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('asistencias.store') }}" class="space-y-6">
            @csrf

            <!-- Grupo -->
            <div>
                <x-input-label for="grupo" value="Filtrar por grupo" />
                <select id="grupo" name="grupo" class="grupo-select mt-1 block w-full rounded border-gray-300">
                    <option value="">-- Selecciona un grupo --</option>
                    @foreach ($grupos as $grupo)
                        <option value="{{ $grupo }}" @selected(old('grupo') === $grupo)>{{ $grupo }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Alumno -->
            <div>
                <x-input-label for="alumno_id" value="Alumno" />
                <select id="alumno_id" name="alumno_id" class="alumno-select mt-1 block w-full rounded border-gray-300" required>
                    <option value="">-- Selecciona un alumno --</option>
                    @foreach ($alumnos as $alumno)
                        <option value="{{ $alumno->id }}" @selected(old('alumno_id') == $alumno->id)>
                            {{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('alumno_id')" class="mt-2" />
            </div>

            <!-- Tipo de clase -->
            <div>
                <x-input-label for="tipo_clase_id" value="Tipo de Clase" />
                <select id="tipo_clase_id" name="tipo_clase_id" class="mt-1 block w-full rounded border-gray-300" required>
                    <option value="">-- Selecciona un tipo --</option>
                    @foreach ($tiposClase as $tipo)
                        <option value="{{ $tipo->id }}" @selected(old('tipo_clase_id') == $tipo->id)>
                            {{ $tipo->nombre_clase }} ({{ $tipo->grupo }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('tipo_clase_id')" class="mt-2" />
            </div>

            <!-- Fecha -->
            <div>
                <x-input-label for="fecha" value="Fecha" />
                <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full"
                    value="{{ old('fecha', date('Y-m-d')) }}" required />
                <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
            </div>

            <!-- Estado (checkbox presente) -->
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="estado" value="presente" class="rounded border-gray-300 text-green-600"
                        {{ old('estado') === 'presente' ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Presente</span>
                </label>
            </div>

            <!-- Comentario (si está ausente) -->
            <div>
                <x-input-label for="comentario" value="Comentario (solo si está ausente o justificado)" />
                <textarea id="comentario" name="comentario"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('comentario') }}</textarea>
                <x-input-error :messages="$errors->get('comentario')" class="mt-2" />
            </div>

            <!-- Recuperación -->
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="es_recuperacion" value="1" class="rounded border-gray-300 text-blue-600"
                        {{ old('es_recuperacion') ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">¿Es una clase de recuperación?</span>
                </label>
            </div>

            <div class="flex justify-end">
                <x-primary-button>Registrar</x-primary-button>
            </div>
        </form>
    </div>

    <!-- Scripts para Select2 -->
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.alumno-select').select2({
                    placeholder: 'Buscar alumno...',
                    width: '100%'
                });

                $('.grupo-select').select2({
                    placeholder: 'Filtrar por grupo',
                    width: '100%'
                });
            });
        </script>
    @endpush
</x-app-layout>
