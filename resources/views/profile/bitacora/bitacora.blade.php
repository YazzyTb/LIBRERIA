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
        <main class="flex-1 p-4">
            <h1 class="text-2xl font-semibold mb-4 text-gray-800">Bitácora</h1>

            <!-- Buscador -->
            <div class="relative w-full max-w-sm ml-auto mb-4">
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar en bitácora..."
                    class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition duration-300">
            </div>

            <!-- Tabla Bitácora -->
            <div class="overflow-auto shadow-lg border border-gray-300 rounded-lg" style="max-height: 500px;">
                <table id="bitacoraTable" class="min-w-full table-auto bg-white text-sm">
                    <thead class="sticky top-0 bg-gray-200 text-gray-600 uppercase leading-normal">
                        <tr class="text-left">
                            <th class="px-2 py-3 bg-gray-200">ID</th>
                            <th class="px-2 py-3 bg-gray-200">Tabla Afectada</th>
                            <th class="px-2 py-3 bg-gray-200">Acción</th>
                            <th class="px-2 py-3 bg-gray-200">Usuario</th>
                            <th class="px-2 py-3 bg-gray-200">Fecha y Hora</th>
                            <th class="px-2 py-3 bg-gray-200">Datos Anteriores</th>
                            <th class="px-2 py-3 bg-gray-200">Datos Nuevos</th>
                            <th class="px-2 py-3 bg-gray-200">Dirección IP</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light">
                        @foreach ($bitacora as $registro)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 text-left">
                                <td class="px-2 py-2 md:px-6 md:py-4">{{ $registro->id }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-4">{{ $registro->tabla_afectada }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-4">{{ $registro->accione_id }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-4">{{ $registro->user_id }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-4">{{ $registro->fecha_hora }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-4 max-w-xs overflow-hidden text-ellipsis whitespace-pre-wrap break-words">{{ $registro->datos_anteriores }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-4 max-w-xs overflow-hidden text-ellipsis whitespace-pre-wrap break-words">{{ $registro->datos_nuevos }}</td>
                                <td class="px-2 py-2 md:px-6 md:py-4">{{ $registro->ip_address }}</td>
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
            const table = document.getElementById("bitacoraTable");
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
