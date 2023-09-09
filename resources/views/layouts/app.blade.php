<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            {{-- {{ config('app.name', 'Laravel') }} --}}
            One Mfg
        </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <input type="hidden" value="{{ csrf_token() }}"  id="ajaxtokengeneral">
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="{{ asset('css/jsgrid.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jsgrid-theme.min.css') }}">
        {{-- <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script> --}}
        {{-- <script src="../../public/js/jsgrid.js"></script> --}}
        <script type="text/javascript" src="{{ asset('js/jsgrid.js') }}"></script>

        {{-- <script src="../../public/js/jsgrid.min.js"></script> --}}
        {{-- <script type="text/javascript" src="{{ asset('js/jsgrid.min.js') }}"></script> --}}
        <style>
            /* Agrega el efecto de transición al modal */
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <footer class="text-center p-5 text-gray-500 font-bold uppercase">
                One Mfg - Todos los derechos reservados {{ now()->format('Y') }}
                @if(session('opcion_seleccionada'))
                    <p>La opción seleccionada es: {{ session('opcion_seleccionada') }}</p>
                @endif

            </footer>
        </div>
        <div id="myModal" class="modal absolute inset-0 flex items-center justify-center z-50 hidden">
            <div class="modal-background  inset-0 bg-black opacity-50"></div>
            <div class="modal-content bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Selecciona un empresa</h2>
                <select id="opciones" class="block w-full px-4 py-2 border rounded-lg mb-4">
                    <option value="1">One MFG</option>
                    <option value="2">Prescision Manufacturing</option>

                </select>
                <button id="seleccionar" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Seleccionar</button>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("myModal");
            const select = document.getElementById("opciones");
            const botonSeleccionar = document.getElementById("seleccionar");

            // Verificar si la opción existe en sesión
            const opcionEnSesion = '{{ session("opcion_seleccionada") }}';
            if (!opcionEnSesion) {
                modal.classList.remove("hidden"); // Mostrar el modal si la opción no existe en sesión
            }

            botonSeleccionar.addEventListener("click", function () {
                const opcionSeleccionada = select.value;

                // Guardar la opción seleccionada en la sesión de Laravel
                fetch('/guardar-opcion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Agrega el token CSRF de Laravel
                    },
                    body: JSON.stringify({ opcion: opcionSeleccionada }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        modal.classList.add("hidden"); // Cerrar el modal después de seleccionar
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
        </script>

    </body>
</html>
