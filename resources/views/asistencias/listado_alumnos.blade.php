<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Asistencia Semanal</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <form method="GET" class="mb-4">
            <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por nombre, grado o grupo" class="border rounded-md px-4 py-2 w-full md:w-1/3">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Buscar</button>
        </form>

        <div class="overflow-x-auto" x-data="{ filtro: '' }">
            <input type="text" x-model="filtro" placeholder="Filtrar resultados..." class="mb-2 border rounded px-2 py-1 w-full md:w-1/4" />
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Alumno</th>
                        <th class="px-4 py-2 text-left">Grupo</th>
                        <th class="px-4 py-2 text-left">Total de clases</th>
                        <th class="px-4 py-2 text-left">Clases Tradicional</th>
                        <th class="px-4 py-2 text-left">Clases Sanda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnos as $alumno)
                        @php
                            $plan = optional($alumno->alumnoPlan)->plan;
                            $maxTrad = $plan->cant_clases_tradicional ?? 0;
                            $maxSanda = $plan->cant_clases_sanda ?? 0;
                            $maxExtra = $plan->cant_clases_extra ?? 0;
                            $totalMax = $maxTrad + $maxSanda + $maxExtra;
                            $tradCount = $alumno->asistencias->filter(fn($a) => strtolower(optional($a->tipoClase)->nombre_clase) === 'tradicional')->count();
                            $sandaCount = $alumno->asistencias->filter(fn($a) => strtolower(optional($a->tipoClase)->nombre_clase) === 'sanda')->count();
                            $totalCount = $alumno->asistencias->count();
                            $grupo = $alumno->grupo;
                        @endphp
                        <tr x-data="asistenciaRow({{ $alumno->id }}, {{ min($tradCount, $maxTrad) }}, {{ min($sandaCount, $maxSanda) }}, {{ min($totalCount, $totalMax) }}, {{ $maxTrad }}, {{ $maxSanda }}, {{ $totalMax }})"
                            x-show="'{{ strtolower($alumno->nombre_alumno.' '.$alumno->apellido_paterno.' '.$alumno->apellido_materno.' '.$alumno->grado.' '.$grupo) }}'.includes(filtro.toLowerCase())">                            <td class="border px-4 py-2">{{ $alumno->nombre_alumno }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</td>
                            <td class="border px-4 py-2">{{ $grupo }}</td>
                            <td class="border px-4 py-2"><span x-text="total"></span> de {{ $totalMax }}</td>
                            <td class="border px-4 py-2">
                                <span x-text="trad"></span> de {{ $maxTrad }}
                                <button x-show="trad < maxTrad && total < totalMax" @click="increment('tradicional')" type="button" class="ml-2 bg-green-500 text-white px-2 py-1 rounded">+</button>
                            </td>
                            <td class="border px-4 py-2">
                                <span x-text="sanda"></span> de {{ $maxSanda }}
                                <button x-show="sanda < maxSanda && total < totalMax" @click="increment('sanda')" type="button" class="ml-2 bg-green-500 text-white px-2 py-1 rounded">+</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            window.asistenciaRow = function (alumnoId, trad, sanda, total, maxTrad, maxSanda, totalMax) {
                return {
                    trad,
                    sanda,
                    total,
                    maxTrad,
                    maxSanda,
                    totalMax,
                    async increment(tipo) {
                        if (this.total >= this.totalMax) return;
                        if (tipo === 'tradicional' && this.trad >= this.maxTrad) return;
                        if (tipo === 'sanda' && this.sanda >= this.maxSanda) return;

                        try {
                            const response = await fetch('{{ route('asistencia.increment') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ alumno_id: alumnoId, tipo })
                            });

                            if (!response.ok) {
                                console.error('Increment failed', response.status);
                                return;
                            }

                            const data = await response.json().catch(() => null);

                            if (data && data.success) {
                                this.trad = data.trad;
                                this.sanda = data.sanda;
                                this.total = data.total;
                                } else {
                                if (tipo === 'tradicional' && this.trad < this.maxTrad) {
                                    this.trad++;
                                }

                                if (tipo === 'sanda' && this.sanda < this.maxSanda) {
                                    this.sanda++;
                                }

                                if (this.total < this.totalMax) {
                                    this.total++;
                                }
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    }
                };
            }
        });
    </script>
</x-app-layout>