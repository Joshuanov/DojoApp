<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Crear Tipo de Clase
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('tipo_clase.store') }}" class="space-y-6">
            @csrf

            <!-- Nombre de la clase -->
            <div>
                <x-input-label for="nombre_clase" value="Nombre de la Clase" />
                <x-text-input id="nombre_clase" name="nombre_clase" type="text" class="mt-1 block w-full" value="{{ old('nombre_clase') }}" required />
                <x-input-error :messages="$errors->get('nombre_clase')" class="mt-2" />
            </div>

            <!-- Descripción -->
            <div>
                <x-input-label for="descripcion" value="Descripción (opcional)" />
                <textarea id="descripcion" name="descripcion" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion') }}</textarea>
                <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
            </div>

            <!-- Duración -->
            <div>
                <x-input-label for="duracion" value="Duración (minutos)" />
                <x-text-input id="duracion" name="duracion" type="number" class="mt-1 block w-full" value="{{ old('duracion') }}" min="1" required />
                <x-input-error :messages="$errors->get('duracion')" class="mt-2" />
            </div>

            <!-- Grupo -->
            <div>
                <x-input-label for="grupo" value="Grupo" />
                <select id="grupo" name="grupo" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Selecciona un grupo</option>
                    @foreach(['Tiger', 'Junior', 'Senior', 'Adultos', 'Sanda', 'Seminario'] as $grupo)
                        <option value="{{ $grupo }}" @selected(old('grupo') === $grupo)>{{ $grupo }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('grupo')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>Guardar</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
