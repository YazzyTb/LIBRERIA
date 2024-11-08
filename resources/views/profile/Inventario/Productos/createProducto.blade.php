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
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <aside class="w-1/5"></aside>

        <!-- Page Content -->
        <main class="flex-1 p-4 mt-20">
            <h1 class="text-2xl font-semibold mb-4">Registrar nuevo producto</h1>

            <form method="POST" action="{{ route('producto.store') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Código -->
                <div>
                    <x-input-label for="codigo" :value="__('Código')" />
                    <x-text-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" :value="old('codigo')" required autofocus autocomplete="codigo" placeholder="LIB-12345" />
                    <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
                </div>

                <!-- Nombre -->
                <div class="mt-4">
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autocomplete="nombre" />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <!-- Precio -->
                <div class="mt-4">
                    <x-input-label for="precio" :value="__('Precio')" />
                    <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" :value="old('precio')" required autocomplete="precio" />
                    <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                </div>

                <!-- Fecha de Publicación -->
                <div class="mt-4">
                    <x-input-label for="fecha_de_publicacion" :value="__('Fecha de Publicación')" />
                    <x-text-input id="fecha_de_publicacion" class="block mt-1 w-full" type="date" name="fecha_de_publicacion" :value="old('fecha_de_publicacion')" required autocomplete="fecha_de_publicacion" />
                    <x-input-error :messages="$errors->get('fecha_de_publicacion')" class="mt-2" />
                </div>

                <!-- Editorial -->
                <div class="mt-4">
                    <x-input-label for="editorial" :value="__('Editorial')" />
                    <x-text-input id="editorial" class="block mt-1 w-full" type="text" name="editoriale_id" :value="old('editoriale_id')" required autocomplete="editorial" placeholder="Nombre de la Editorial" />
                    <x-input-error :messages="$errors->get('editoriale_id')" class="mt-2" />
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
