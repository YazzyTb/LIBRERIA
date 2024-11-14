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
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-1/5"></aside>

        <!-- Page Content -->
        <main class="flex-1 p-4">
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

                <!-- Tipo de Producto -->
                <div class="mt-4">
                    <x-input-label for="producto_tipo" :value="__('Tipo de Producto')" />
                    <select name="producto_tipo" id="producto_tipo" class="block mt-1 w-full" onchange="toggleFields()">
                        <option value="1" {{ old('producto_tipo') == '1' ? 'selected' : '' }}>Libro</option>
                        <option value="2" {{ old('producto_tipo') == '2' ? 'selected' : '' }}>Revista</option>
                        <option value="3" {{ old('producto_tipo') == '3' ? 'selected' : '' }}>Enciclopedia</option>
                    </select>
                    <x-input-error :messages="$errors->get('producto_tipo')" class="mt-2" />
                </div>   

                <!-- Campos adicionales por tipo de producto -->
                <div id="fields_libro" style="display: none;">
                    <!-- Autores (separados por comas) -->
                    <div class="mt-4">
                        <x-input-label for="autores" :value="__('Autor/es')" />
                        <x-text-input id="autores" class="block mt-1 w-full" type="text" name="autores" placeholder="Autor 1, Autor 2" />
                    </div>
                    <!-- Tipo de tapa y edición del libro -->
                    <div class="mt-4">
                        <x-input-label for="tipo_de_tapa" :value="__('Tipo de Tapa')" />
                        <x-text-input id="tipo_de_tapa" class="block mt-1 w-full" type="text" name="tipo_de_tapa" placeholder="Tipo de Tapa" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="edicion_libro" :value="__('Edición')" />
                        <x-text-input id="edicion_libro" class="block mt-1 w-full" type="number" name="edicion_libro" />
                    </div>
                </div>

                <div id="fields_revista" style="display: none;">
                    <div class="mt-4">
                        <x-input-label for="nro" :value="__('Número de Revista')" />
                        <x-text-input id="nro" class="block mt-1 w-full" type="number" name="nro" placeholder="Número de Revista" />
                    </div>
                </div>

                <div id="fields_enciclopedia" style="display: none;">
                    <div class="mt-4">
                        <x-input-label for="volumen" :value="__('Volumen')" />
                        <x-text-input id="volumen" class="block mt-1 w-full" type="number" name="volumen" placeholder="Volumen de la Enciclopedia" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="edicion_enciclopedia" :value="__('Edición')" />
                        <x-text-input id="edicion_enciclopedia" class="block mt-1 w-full" type="number" name="edicion_enciclopedia" placeholder="Edición de la Enciclopedia" />
                    </div>
                </div>

                <!-- Género -->
                <div class="mt-4">
                    <x-input-label for="genero" :value="__('Género')" />
                    <select name="generos[]" id="genero" multiple required
                            class="block mt-1 w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        @foreach ($generos as $genero)
                            <option value="{{ $genero->id }}" class="py-1">{{ $genero->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('generos')" class="mt-2" />
                </div>

                <!-- Botón Guardar -->
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('producto.index') }}" class="px-4 py-2 mr-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">Cancelar</a>
                    
                    <x-primary-button class="ms-4">
                        {{ __('Guardar') }}
                    </x-primary-button>
                </div>
            </form>
        </main>
    </div>

    <!-- JavaScript para mostrar/ocultar campos según el tipo de producto -->
    <script>
        function toggleFields() {
            const tipoProducto = document.getElementById('producto_tipo').value;
            document.getElementById('fields_libro').style.display = tipoProducto === '1' ? 'block' : 'none';
            document.getElementById('fields_revista').style.display = tipoProducto === '2' ? 'block' : 'none';
            document.getElementById('fields_enciclopedia').style.display = tipoProducto === '3' ? 'block' : 'none';
        }
        
        // Llamar a toggleFields al cargar la página por si hay un valor preseleccionado
        window.onload = toggleFields;
    </script>
</body>
</html>
