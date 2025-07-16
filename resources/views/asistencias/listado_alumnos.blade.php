<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Asistencia Semanal</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <form method="GET" class="mb-4">
            <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por nombre, grado o grupo" class="border rounded-md px-4 py-2 w-full md:w-1/3">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Buscar</button>
        </form>

       <div class="overflow-x-auto" x-data="asistenciaTable()" @cambio.window="registrarCambio($event)">
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
                                <button x-show="trad > 0" @click="decrement('tradicional')" type="button" class="ml-2 bg-red-500 text-white px-2 py-1 rounded">-</button>
                            </td>
                            <td class="border px-4 py-2">
                                <span x-text="sanda"></span> de {{ $maxSanda }}
                                <button x-show="sanda < maxSanda && total < totalMax" @click="increment('sanda')" type="button" class="ml-2 bg-green-500 text-white px-2 py-1 rounded">+</button>
                            <button x-show="sanda > 0" @click="decrement('sanda')" type="button" class="ml-2 bg-red-500 text-white px-2 py-1 rounded">-</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button @click="guardar" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded" type="button">Guardar asistencias</button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            window.asistenciaTable = function () {
                return {
                    filtro: '',
                    cambios: {},
                    registrarCambio(event) {
                        const { alumnoId, tipo, delta } = event.detail;
                        if (!this.cambios[alumnoId]) {
                            this.cambios[alumnoId] = { trad: 0, sanda: 0 };
                        }
                        this.cambios[alumnoId][tipo] += delta;
                    },
                    async guardar() {
                        const payload = Object.entries(this.cambios).map(([id, cambios]) => ({
                            alumno_id: id,
                            trad: cambios.trad,
                            sanda: cambios.sanda
                        }));
                        if (payload.length === 0) return;
                        try {
                            const response = await fetch('{{ route('asistencia.guardar') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ cambios: payload })
                            });
                            if (response.ok) {
                                this.cambios = {};
                                alert('Asistencias guardadas correctamente');
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    }
                };
                };

            window.asistenciaRow = function (alumnoId, trad, sanda, total, maxTrad, maxSanda, totalMax) {
                return {
                    trad,
                    sanda,
                    total,
                    maxTrad,
                    maxSanda,
                    totalMax,
                    increment(tipo) {
                        if (this.total >= this.totalMax) return;
                        if (tipo === 'tradicional' && this.trad >= this.maxTrad) return;
                        if (tipo === 'sanda' && this.sanda >= this.maxSanda) return;
                        if (!confirm(`¿Confirmas que el alumno asistió a clase ${tipo === 'tradicional' ? 'Tradicional' : 'Sanda'} hoy?`)) return;

                        if (tipo === 'tradicional') {
                            this.trad++;
                            this.$dispatch('cambio', { alumnoId, tipo: 'trad', delta: 1 });
                        } else {
                            this.sanda++;
                            this.$dispatch('cambio', { alumnoId, tipo: 'sanda', delta: 1 });
                        }
                        this.total++;
                    },
                    decrement(tipo) {
                        if (tipo === 'tradicional' && this.trad > 0 && confirm('¿Confirmas revertir asistencia Tradicional?')) {
                            this.trad--;
                            this.total--;
                            this.$dispatch('cambio', { alumnoId, tipo: 'trad', delta: -1 });
                        }
                        if (tipo === 'sanda' && this.sanda > 0 && confirm('¿Confirmas revertir asistencia Sanda?')) {
                            this.sanda--;
                            this.total--;
                            this.$dispatch('cambio', { alumnoId, tipo: 'sanda', delta: -1 });
                        }
                    }
                };
            }
        });
    </script>
</x-app-layout>