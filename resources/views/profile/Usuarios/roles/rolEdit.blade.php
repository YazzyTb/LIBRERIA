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
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 ">Editar Rol</h1>

            <form method="POST" action="{{ route('roles.update', ['role' => $role->id]) }}" class="space-y-6">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif   

                <!-- ID (readonly) -->
                <div>
                    <label for="id" class="block text-lg font-medium text-gray-700">ID</label>
                    <input type="number" name="id" id="id" class="mt-1 block w-full bg-gray-200 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('id', $role->id) }}" readonly>
                </div>

                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-lg font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('nombre', $role->nombre) }}">
                </div>

                <!-- Selección de Privilegios -->
                <div>
                    <label class="block text-lg font-medium text-gray-700">Privilegios</label>
                    <div class="grid grid-cols-2 mt-2 space-y-2">
                        @foreach($privilegios as $privilegio)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="privilegios[]" value="{{ $privilegio->id }}"
                                           data-descripcion="{{ $privilegio->descripcion }}"
                                           class="privilegio-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded"
                                           onchange="updateDescripcion()"
                                           {{ in_array($privilegio->id, $role->privilegios->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700">{{ $privilegio->nombre }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-lg font-medium text-gray-700">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Descripción de los privilegios seleccionados" readonly>{{ old('descripcion', $role->descripcion) }}</textarea>
                </div>

                <!-- Botones de acción -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('roles.index') }}" class="px-4 py-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">Cancelar</a>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Guardar</button>
                </div>
            </form>
        </main>
    </div>

    <!-- JavaScript para actualizar la descripción -->
    <script>
        // Almacena las descripciones seleccionadas en un Set para evitar duplicados
        let descripcionesSeleccionadas = new Set();

        function updateDescripcion() {
            const checkboxes = document.querySelectorAll(".privilegio-checkbox");

            checkboxes.forEach((checkbox) => {
                const descripcion = checkbox.getAttribute("data-descripcion");
                
                if (checkbox.checked) {
                    descripcionesSeleccionadas.add(descripcion);
                } else {
                    descripcionesSeleccionadas.delete(descripcion);
                }
            });

            // Actualiza el campo de descripción con las descripciones seleccionadas, separadas por comas
            document.getElementById("descripcion").value = Array.from(descripcionesSeleccionadas).join(', ');
        }

        // Carga inicial de descripciones en caso de que haya privilegios seleccionados al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll(".privilegio-checkbox");
            
            // Inicializa el Set con las descripciones de los checkboxes que están preseleccionados
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    descripcionesSeleccionadas.add(checkbox.getAttribute("data-descripcion"));
                }
            });

            // Actualiza el campo de descripción con las descripciones inicialmente seleccionadas
            document.getElementById("descripcion").value = Array.from(descripcionesSeleccionadas).join(', ');
        });
    </script>
</body>
</html>
