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
            <h1 class="text-2xl font-semibold mb-4">Registrar nuevo cliente</h1>

            <form method="POST" action="{{ route('cliente.store') }}">
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
        
                <div>
                    <x-input-label for="ci" :value="__('CI')" />
                    <x-text-input id="ci" class="block mt-1 w-full" type="text" name="ci" :value="old('ci')" required autofocus autocomplete="ci" />
                    <x-input-error :messages="$errors->get('ci')" class="mt-2" />
                </div>
        
                <!-- Name -->
                <div>
                    <x-input-label for="nombre" :value="__('Name')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="puntos" :value="__('Puntos')" />
                    <x-text-input id="puntos" class="block mt-1 w-full" type="number" name="puntos" :value="old('puntos')" required autofocus autocomplete="puntos" />
                    <x-input-error :messages="$errors->get('puntos')" class="mt-2" />
                </div>
           
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

    

