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
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Listado de Empleados</h1>

            <!-- Buscador y Botón de Registro -->
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('empleados.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                 Nuevo Empleado
                </a>
                
                <!-- Buscador -->
                <div class="relative w-full max-w-sm ml-auto">
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar empleado..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition duration-300">
                </div>
            </div>

            <!-- Contenedor de tabla con desplazamiento responsivo -->
            <div class="overflow-auto shadow-lg border border-gray-300 rounded-lg" style="max-height: 500px;">
                <table id="empleadoTable" class="min-w-full bg-white text-sm">
                    <thead class="sticky top-0 bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">CI</th>
                            <th class="px-6 py-3 text-left font-medium">Nombre</th>
                            <th class="px-6 py-3 text-left font-medium">Email</th>
                            <th class="px-6 py-3 text-left font-medium">Rol</th>
                            <th class="px-6 py-3 text-left font-medium">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 font-light">
                        @foreach($empleados as $empleado)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $empleado->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $empleado->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $empleado->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $empleado->role->nombre ?? 'Sin Rol' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded-lg transition duration-300">
                                        Editar
                                    </a>
                                    <form action="{{ route('empleados.delete', $empleado->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este empleado?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-lg transition duration-300">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>                                 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Script para el filtro de la tabla -->
    <script>
        function filterTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const table = document.getElementById("empleadoTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    const cellContent = cells[j].textContent || cells[j].innerText;
                    if (cellContent.toLowerCase().includes(searchInput)) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? "" : "none";
            }
        }
    </script>
</body>
</html>
