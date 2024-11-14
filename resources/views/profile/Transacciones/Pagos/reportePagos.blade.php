<!-- resources/views/profile/Transacciones/Pagos/reportePagos.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Reporte de Pagos</title>

    <!-- Fonts y Scripts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.sidebar')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-1/5"></aside>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-semibold mb-4">Reporte de Pagos</h1>

            <!-- Verificación de sesión para la alerta -->
            @if (session('alert'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('alert') }}</span>
                </div>
            @endif

            <!-- Tabla de productos con ganancias, inversiones y total -->
            <div class="overflow-auto shadow-lg border border-gray-300 rounded-lg">
                <table class="min-w-full bg-white rounded-lg">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium">Código</th>
                            <th class="px-6 py-3 text-left font-medium">Producto</th>
                            <th class="px-6 py-3 text-left font-medium">Ganancia</th>
                            <th class="px-6 py-3 text-left font-medium">Inversión</th>
                            <th class="px-6 py-3 text-left font-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light">
                        @foreach ($productos as $index => $producto)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $producto->codigo }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $producto->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $ganancia[$index] ?? 'No disponible' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $inversion[$index] ?? 'No disponible' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ ($ganancia[$index] ?? 0) - ($inversion[$index] ?? 0) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

          
        </main>
    </div>
</body>
</html>