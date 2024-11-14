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
            <h1 class="text-2xl font-semibold mb-4">Registrar nuevo proveedor</h1>

            <form method="POST" action="{{ route('proveedor.store') }}">
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
        
                <!-- Name -->
                <div>
                    <x-input-label for="nombre" :value="__('Empresa')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="persona_de_contacto" :value="__('persona_de_contacto')" />
                    <x-text-input id="persona_de_contacto" class="block mt-1 w-full" type="text" name="persona_de_contacto" :value="old('persona_de_contacto')" required autofocus autocomplete="persona_de_contacto" />
                    <x-input-error :messages="$errors->get('persona_de_contacto')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono_de_contacto" :value="__('telefono_de_contacto')" />
                    <x-text-input id="telefono_de_contacto" class="block mt-1 w-full" type="number" name="telefono_de_contacto" :value="old('telefono_de_contacto')" required autofocus autocomplete="telefono_de_contacto" />
                    <x-input-error :messages="$errors->get('telefono_de_contacto')" class="mt-2" />
                </div>
           
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('proveedor.index') }}" class="px-4 py-2 mr-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">Cancelar</a>
                    <x-primary-button class="ms-4">
                        {{ __('Guardar') }}
                    </x-primary-button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
