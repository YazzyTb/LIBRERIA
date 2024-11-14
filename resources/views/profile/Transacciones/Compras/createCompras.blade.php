<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Registrar Compra</title>

    <!-- Fonts and Scripts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.sidebar')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-1/5"></aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-semibold mb-4">Registrar Nueva Compra</h1>

            <form method="POST" action="{{ route('compra.store') }}">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Fecha de Compra -->
                <div class="mb-4">
                    <label for="fecha" class="block text-gray-700 font-semibold">Fecha de Compra</label>
                    <input type="date" id="fecha" name="fecha" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                </div>

                <!-- Selección del Proveedor -->
                <div class="mb-4">
                    <label for="proveedore_id" class="block text-gray-700 font-semibold">Proveedor</label>
                    <select name="proveedore_id" id="proveedore_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Lista de Productos -->
                <h2 class="text-xl font-semibold mt-6 mb-4">Productos con Stock Bajo</h2>
                <div id="product-list">
                    @forelse ($productosConStockBajo as $codigo => $nombre)
                        <div class="product-item mb-4 p-4 border border-gray-300 rounded-lg bg-white">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="productos[{{ $codigo }}][selected]" value="1" class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="text-gray-700 font-semibold">{{ $nombre }}</span>
                            </label>

                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <label for="productos[{{ $codigo }}][cantidad]" class="block text-gray-600">Cantidad</label>
                                    <input type="number" name="productos[{{ $codigo }}][cantidad]" class="w-full border border-gray-300 rounded-lg px-3 py-2" min="1">
                                </div>

                                <div>
                                    <label for="productos[{{ $codigo }}][precio]" class="block text-gray-600">Precio Unitario</label>
                                    <input type="number" name="productos[{{ $codigo }}][precio]" class="w-full border border-gray-300 rounded-lg px-3 py-2" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">No hay productos con stock bajo.</p>
                    @endforelse
                </div>

                <!-- Botón de Guardar -->
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:bg-blue-600">
                        Registrar Compra
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>