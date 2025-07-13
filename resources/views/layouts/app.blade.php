<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">




    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">



    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!--Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>



</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>


    <!-- jQuery (requerido por Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rutInput = document.getElementById('rut');

            function limpiarRut(rut) {
                return rut.replace(/[^\dkK]/g, '').toUpperCase();
            }

            function formatearRut(rut) {
                rut = limpiarRut(rut);
                if (rut.length < 2) return rut;
                let cuerpo = rut.slice(0, -1);
                let dv = rut.slice(-1);
                return `${cuerpo}-${dv}`;
            }

            rutInput.addEventListener('input', () => {
                const pos = rutInput.selectionStart;
                const largoAntes = rutInput.value.length;

                rutInput.value = formatearRut(rutInput.value);

                const largoDespues = rutInput.value.length;
                rutInput.selectionStart = rutInput.selectionEnd = pos + (largoDespues - largoAntes);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#select-alumno-plan').select2({
                placeholder: "Seleccione un alumno",
                width: '100%'
            });
        });
    </script>

    {{-- Script para calcular fecha fin real --}}
    <script>
        function calcularFechaFin() {
            const inicio = document.getElementById('fecha_inicio').value;
            const meses = parseInt(document.getElementById('duracion_meses').value);

            if (inicio && !isNaN(meses)) {
                const fecha = new Date(inicio);
                fecha.setMonth(fecha.getMonth() + meses);

                const iso = fecha.toISOString().split('T')[0];
                document.getElementById('fecha_fin_real').value = iso;
                document.getElementById('fecha_fin_real_hidden').value = iso;
            } else {
                document.getElementById('fecha_fin_real').value = '';
                document.getElementById('fecha_fin_real_hidden').value = '';
            }
        }

        document.getElementById('fecha_inicio').addEventListener('change', calcularFechaFin);
        document.getElementById('duracion_meses').addEventListener('input', calcularFechaFin);

        window.addEventListener('DOMContentLoaded', calcularFechaFin);
    </script>

    {{-- Select2 --}}
    <script>
        $(document).ready(function() {
            $('#alumno_id').select2({
                placeholder: 'Selecciona un alumno',
                width: '100%'
            });
            /*$('#plan_id').select2({
                placeholder: 'Selecciona un plan',
                width: '100%'
            });*/
        });
    </script>

</body>

</html>
