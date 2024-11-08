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

    @include('layouts.sidebar')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Sidebar -->
        <aside class="w-72"></aside>


        <!-- Page Content -->
        <main class="flex-1 p-8 ">
            <h1 class="text-3xl font-bold text-gray-800">Agregar Nuevo Rol</h1>

            <div class="container mx-auto">
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md mx-auto">
                    <form action="{{ route('roles.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-lg font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Nombre del rol" required>
                        </div>

                        <!-- Selección de Privilegios -->
                        <div>
                            <label class="block text-lg font-medium text-gray-700">Privilegios</label>
                            <div class="grid grid-cols-2  mt-2 space-y-2">
                                @foreach($privilegios as $privilegio)
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="privilegios[]" value="{{ $privilegio->id }}" data-descripcion="{{ $privilegio->descripcion }}" class="privilegio-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded" onchange="updateDescripcion()">
                                            <span class="ml-2 text-gray-700">{{ $privilegio->nombre }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block text-lg font-medium text-gray-700">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Descripción de los privilegios seleccionados" readonly></textarea>
                        </div>

                        <!-- Botón Guardar -->
                        <div class="text-center">
                            <a href="{{ route('roles.index') }}" class="px-4 py-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">Cancelar</a>
                            <button type="submit" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript para actualizar la descripción -->
    <script>
        function updateDescripcion() {
            // Selecciona todas las casillas de verificación con clase 'privilegio-checkbox'
            const checkboxes = document.querySelectorAll(".privilegio-checkbox");
            let descripcionesSeleccionadas = [];

            // Recorre las casillas de verificación seleccionadas
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    // Agrega la descripción al array si la casilla está seleccionada
                    descripcionesSeleccionadas.push(checkbox.getAttribute("data-descripcion"));
                }
            });

            // Actualiza el campo de descripción con las descripciones seleccionadas, separadas por comas
            document.getElementById("descripcion").value = descripcionesSeleccionadas.join(', ');
        }
    </script>
</body>
</html>
