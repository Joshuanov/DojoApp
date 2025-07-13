<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">Asistencia Masiva por Grupo</h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('asistencias.masiva.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="tipo_clase_id" class="block font-medium text-sm text-gray-700">Tipo de Clase</label>
                    <select name="tipo_clase_id" id="tipo_clase_id" class="form-select mt-1 block w-full" required>
                        <option value="">Seleccione una clase</option>
                        @foreach ($tiposClase as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre_clase }} ({{ $tipo->grupo }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="fecha" class="block font-medium text-sm text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-input mt-1 block w-full" required
                        value="{{ date('Y-m-d') }}">
                </div>

                @php
                    $agrupados = $alumnos->groupBy(function ($alumno) {
                        return optional($alumno->asistencias->last()->tipoClase)->grupo ?? 'Sin grupo';
                    });
                @endphp

                @foreach ($agrupados as $grupo => $grupoAlumnos)
                    <h3 class="text-lg font-semibold mt-6 mb-2 text-blue-700">Grupo: {{ $grupo }}</h3>
                    <table class="table-auto w-full mb-6 border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Nombre del Alumno</th>
                                <th class="px-4 py-2 text-left">Marcar Presente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grupoAlumnos as $alumno)
                                @php
                                    $tipo_clase_id = old('tipo_clase_id');
                                    $fecha = old('fecha', date('Y-m-d'));

                                    $yaRegistrado = $alumno->asistencias->contains(function ($asistencia) use (
                                        $tipo_clase_id,
                                        $fecha,
                                    ) {
                                        return $asistencia->tipo_clase_id == $tipo_clase_id &&
                                            $asistencia->fecha == $fecha;
                                    });
                                @endphp
                                <tr>
                                    <td class="border px-4 py-2">{{ $alumno->nombre_alumno }}
                                        {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</td>
                                    <td class="border px-4 py-2">
                                        @if ($yaRegistrado)
                                            <span class="text-sm text-red-600">Ya tiene asistencia tomada</span>
                                        @else
                                            <label class="inline-flex items-center mr-4">
                                                <input type="radio" name="asistencias[{{ $alumno->id }}]"
                                                    value="presente" class="form-radio">
                                                <span class="ml-1">Presente</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="asistencias[{{ $alumno->id }}]"
                                                    value="ausente" class="form-radio">
                                                <span class="ml-1">Ausente</span>
                                            </label>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach

                <button type="submit"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                    Guardar Asistencias
                </button>

            </form>
        </div>
    </div>
</x-app-layout>
