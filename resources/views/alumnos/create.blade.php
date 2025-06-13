<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Registrar Alumno</h2>
    </x-slot>

    <div class="py-4 px-6 space-y-4">
        <form action="{{ route('alumnos.store') }}" method="POST">
            @csrf
            @include('alumnos.partials.form', ['alumno' => null])
            <div class="flex gap-2 ml-6">
                <x-primary-button>Guardar</x-primary-button>

                <a href="{{ route('alumnos.index') }}">
                    <x-secondary-button color="canary" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Volver al listado
                    </x-secondary-button>
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
