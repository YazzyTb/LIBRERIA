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
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Cliente</h1>

            <!-- Formulario de Edición de Cliente -->
            <form method="POST" action="{{ route('cliente.update', $cliente->ci) }}" class="space-y-6 bg-white p-8 shadow-md rounded-lg max-w-lg mx-auto">
                @csrf
                @method('PUT')
                
                <!-- Mensajes de Error -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Campo de CI -->
                <div class="flex flex-col">
                    <label for="ci" class="text-gray-700 font-semibold">CI</label>
                    <input type="number" name="ci" value="{{ old('ci', $cliente->ci) }}" class="mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <x-input-error :messages="$errors->get('ci')" class="mt-2" />
                </div>

                <!-- Campo de Nombre -->
                <div class="flex flex-col">
                    <label for="nombre" class="text-gray-700 font-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Campo de Puntos -->
                <div class="flex flex-col">
                    <label for="puntos" class="text-gray-700 font-semibold">Puntos</label>
                    <input type="number" name="puntos" value="{{ old('puntos', $cliente->puntos) }}" class="mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <x-input-error :messages="$errors->get('puntos')" class="mt-2" />
                </div>

                <!-- Botón Guardar -->
                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-300">
                        Guardar
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
