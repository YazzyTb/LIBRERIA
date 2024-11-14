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
            <div class="container mx-auto py-8">
                <h1 class="text-3xl font-bold mb-6 text-gray-700">Listado de Compras</h1>
                
                <!-- Search and Register Button -->
                <div class="flex items-center justify-between mb-6">
                    <a href="{{ route('compra.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                        Registrar Compra
                    </a>

                    <a href="{{ route('pdf.todas') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded-lg transition duration-300">
                        generar PDF
                    </a>

                    <!-- Search Input -->
                    <div class="relative w-full max-w-sm ml-auto">
                        <input type="number" id="searchInput" onkeyup="filterTable()" placeholder="Buscar compra..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition duration-300">
                    </div>
                </div>

                <!-- Responsive Table -->
                <div class="max-w-full overflow-auto shadow-lg border border-gray-300 rounded-lg" style="max-height: 400px;">
                    <table id="clienteTable" class="min-w-full bg-white rounded-lg">
                        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal sticky top-0">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">Nro</th>
                                <th class="px-6 py-3 text-left font-medium">Fecha</th>
                                <th class="px-6 py-3 text-left font-medium">Usuario</th>
                                <th class="px-6 py-3 text-left font-medium">Total</th>
                              <!--  <th class="px-6 py-3 text-left font-medium">Acciones</th>-->
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm font-light">
                            @foreach($compras as $compra)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $compra->nro }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $compra->fecha}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $compra->users->name}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $compra->monto_total}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                                
                                            
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

    <!-- JavaScript for filtering the table -->
    <script>
        function filterTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const table = document.getElementById("clienteTable");
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