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
<body class="font-sans antialiased bg-white-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-1/5 p-4 bg-white-50 ">
            <!-- Sidebar content goes here -->
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <div class="bg-white rounded-lg  p-6 overflow-hidden">
                <h1 class="text-3xl font-bold text-gray-700 mb-6">Listado de Productos</h1>

                <!-- Button and Search Bar -->
                <div class="flex items-center justify-between mb-6">
                    <a href="{{ route('producto.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                        Nuevo Producto
                    </a>
                    <div class="relative w-full max-w-sm ml-auto">
                        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Buscar producto..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition duration-300">
                    </div>
                </div>

                <!-- Products Table with Responsive Wrapping -->
                <div class="overflow-x-auto">
                    <table id="productoTable" class="w-full bg-white rounded-lg shadow-lg border border-gray-300">
                        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium">Código</th>
                                <th class="px-4 py-2 text-left font-medium">Nombre</th>
                                <th class="px-4 py-2 text-left font-medium">Autor</th>
                                <th class="px-4 py-2 text-left font-medium">Precio</th>
                                <th class="px-4 py-2 text-left font-medium">Cantidad</th>
                                <th class="px-4 py-2 text-center font-medium">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm font-light">
                            @foreach ($productos as $producto)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2 whitespace-nowrap max-w-xs overflow-hidden overflow-ellipsis">{{ $producto->codigo }}</td>
                                <td class="px-4 py-2 whitespace-nowrap max-w-xs overflow-hidden overflow-ellipsis">{{ $producto->nombre }}</td>
                                <td class="px-4 py-2 max-w-xs whitespace-normal">
                                    @if ($producto->libros && $producto->libros->autores)
                                        {{ $producto->libros->autores->pluck('nombre')->join(', ') }}
                                    @else
                                        Sin autor relacionado
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $producto->precio }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $producto->stocks->cantidad ?? 'No disponible' }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('producto.show', $producto->codigo) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded-lg transition duration-300">
                                            Ver
                                        </a>
                                        <a href="{{ route('producto.edit', $producto->codigo) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded-lg transition duration-300">
                                            Editar Prod
                                        </a>
                                        <a href="{{ route('stock.edit', $producto->codigo) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded-lg transition duration-300">
                                            Editar Stock
                                        </a>
                                        <form action="{{ route('producto.delete', $producto->codigo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
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
            </div>
        </main>
    </div>

    <!-- JavaScript para el filtro de la tabla -->
    <script>
        function filterTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const table = document.getElementById("productoTable");
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
