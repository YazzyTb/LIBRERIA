<!-- resources/views/profile/productos/editProducto.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Editar Producto</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.sidebar')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <aside class="w-72"></aside>

        <main class="flex-1 p-8">
            <h1 class="text-2xl font-semibold mb-4">Editar Producto</h1>

            <form method="POST" action="{{ route('producto.update', $producto->codigo) }}" class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="codigo" class="block text-gray-700 font-semibold">Código</label>
                    <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $producto->codigo) }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required readonly>
                </div>

                <div class="mt-4">
                    <label for="nombre" class="block text-gray-700 font-semibold">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required>
                </div>

                <div class="mt-4">
                    <label for="precio" class="block text-gray-700 font-semibold">Precio</label>
                    <input type="number" step="0.01" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required>
                </div>

                <div class="mt-4">
                    <label for="fecha_de_publicacion" class="block text-gray-700 font-semibold">Fecha de Publicación</label>
                    <input type="date" id="fecha_de_publicacion" name="fecha_de_publicacion" value="{{ old('fecha_de_publicacion', $producto->fecha_de_publicacion) }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required>
                </div>

                <div class="mt-4">
                    <label for="editorial" class="block text-gray-700 font-semibold">Editorial</label>
                    <input type="text" id="editorial" name="editoriale_id" value="{{ old('editoriale_id', $producto->editorial->nombre ?? '') }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Guardar Cambios') }}
                    </x-primary-button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
