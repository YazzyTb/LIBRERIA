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
            <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-gray-700 mb-6">Detalles del Producto</h1>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">{{ $producto->nombre }}</h2>
                
                <p><strong>Código:</strong> {{ $producto->codigo }}</p>
                <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                <p><strong>Fecha de Publicación:</strong> {{ $producto->fecha_de_publicacion }}</p>
                <p><strong>Editorial:</strong> {{ $producto->editorial->nombre ?? 'N/A' }}</p>
                <p><strong>Géneros:</strong> {{ $producto->generos->pluck('nombre')->join(', ') }}</p>
                <p><strong>Tipo de Producto:</strong> {{ $producto->producto_tipo }}</p>

                <!-- Additional fields for each type -->
                @if ($producto->producto_tipo === 'LIBRO')
                
                    <h3 class="text-lg font-semibold mt-4">Detalles de Libro</h3>
                    <p><strong>Tipo de Tapa:</strong> {{ $tipo->tipo_de_tapa }}</p>
                    <p><strong>Edición:</strong> {{ $tipo->Edicion }}</p>
                    <p><strong>Autores:</strong> {{ $tipo->autores->pluck('nombre')->join(', ') }}</p>
                @elseif ($producto->producto_tipo === 'REVISTA')
                    <h3 class="text-lg font-semibold mt-4">Detalles de Revista</h3>
                    <p><strong>Número de Revista:</strong> {{ $tipo->nro }}</p>
                @elseif ($producto->producto_tipo === 'ENCICLOPEDIA')
                    <h3 class="text-lg font-semibold mt-4">Detalles de Enciclopedia</h3>
                    <p><strong>Volumen:</strong> {{ $tipo->volumen }}</p>
                    <p><strong>Edición:</strong> {{ $tipo->edicion }}</p>
                @endif
            </div>
            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('producto.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                    Volver
                </a>
            </div>
        </main>
    </div>
</body>
</html>
