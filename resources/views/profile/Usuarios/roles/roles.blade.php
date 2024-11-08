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
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Listado de Roles</h1>
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('roles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Nuevo Rol
                </a>
                
                <!-- Buscador -->
                <div class="relative w-full max-w-sm ml-auto">
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar en roles..."
                        class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
            </div>

            <!-- Contenedor para la tabla responsiva -->
            <div class="overflow-auto shadow-lg border border-gray-300 rounded-lg" style="max-height: 500px;">
                <table id="rolesTable" class="min-w-full bg-white rounded-lg shadow overflow-hidden text-sm">
                    <thead class="sticky top-0 bg-gray-200 text-gray-600 uppercase text-xs leading-normal">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">ID</th>
                            <th class="px-4 py-2 text-left font-medium">Nombre</th>
                            <th class="px-4 py-2 text-left font-medium max-w-lg">Descripción</th>
                            <th class="px-4 py-2 text-left font-medium max-w-lg">Privilegios</th>
                            <th class="px-4 py-2 text-left font-medium">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($rol as $role)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-2 whitespace-nowrap">{{ $role->id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $role->nombre }}</td>
                            <td class="px-4 py-2  break-words">{{ $role->descripcion }}</td>
                            <td class="px-4 py-2  break-words">
                                <!-- Columna de Privilegios con cuadrícula -->
                                <div class="grid  sm:grid-cols-3 gap-1">
                                    @foreach($role->privilegios as $privilegio)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-lg">
                                            {{ $privilegio->nombre }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded-lg transition duration-300">
                                        Editar
                                    </a>
                                    <form action="{{ route('roles.delete', $role->id) }}" method="POST">
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

    <!-- Filtro de búsqueda -->
    <script>
        function filterTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const table = document.getElementById("rolesTable");
            const rows = table.querySelectorAll("tbody tr");

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchInput) ? "" : "none";
            });
        }

        document.getElementById("searchInput").addEventListener("input", filterTable);
    </script>
</body>
</html>
