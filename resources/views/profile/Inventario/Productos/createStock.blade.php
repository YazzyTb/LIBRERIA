<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Registro de Stock</title>

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
            <h1 class="text-2xl font-semibold mb-4">Registrar Stock del Producto</h1>

            <form method="POST" action="{{ route('stock.store') }}" class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
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

                <!-- Código del Producto -->
                <div>
                    <label for="producto_codigo" class="block text-gray-700 font-semibold">Código del Producto</label>
                    <input type="text" id="producto_codigo" name="producto_codigo" value="{{ old('producto_codigo', $producto_codigo ?? '') }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" readonly>
                </div>

                <!-- Cantidad -->
                <div class="mt-4">
                    <label for="cantidad" class="block text-gray-700 font-semibold">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" value="{{ old('cantidad') }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required min="0">
                </div>

                <!-- Stock Máximo -->
                <div class="mt-4">
                    <label for="max_stock" class="block text-gray-700 font-semibold">Stock Máximo</label>
                    <input type="number" id="max_stock" name="max_stock" value="{{ old('max_stock') }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required min="0">
                </div>

                <!-- Stock Mínimo -->
                <div class="mt-4">
                    <label for="min_stock" class="block text-gray-700 font-semibold">Stock Mínimo</label>
                    <input type="number" id="min_stock" name="min_stock" value="{{ old('min_stock') }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required min="0">
                </div>

                 <!-- Botón Guardar -->
                 <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Guardar') }}
                    </x-primary-button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
