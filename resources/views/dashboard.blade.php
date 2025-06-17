<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Módulo Alumnos -->
            <a href="{{ route('alumnos.index') }}"
                class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Alumnos</h5>
                <p class="text-gray-700 dark:text-gray-400">Registrar y gestionar alumnos activos.</p>
            </a>

            <!-- Módulo Planes -->
            <a href="{{ route('planes.index') }}"
                class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Planes</h5>
                <p class="text-gray-700 dark:text-gray-400">Crear y administrar planes de entrenamiento.</p>
            </a>

            <!-- Módulo Asignación Plan-Alumno -->
            <a href="{{ route('alumno_plan.index') }}"
                class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Asignar Planes</h5>
                <p class="text-gray-700 dark:text-gray-400">Asociar alumnos a sus respectivos planes.</p>
            </a>

            <!-- Módulo Asistencias -->
            <a href="{{ route('asistencias.index') }}"
                class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Asistencias</h5>
                <p class="text-gray-700 dark:text-gray-400">Registrar y revisar la asistencia diaria de alumnos.</p>
            </a>

            <!-- Módulo Tipos de Clase -->
            <a href="{{ route('tipo_clase.index') }}"
                class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Tipos de Clase</h5>
                <p class="text-gray-700 dark:text-gray-400">Gestionar los tipos de clases y grupos disponibles.</p>
            </a>


        </div>
    </div>
</x-app-layout>
