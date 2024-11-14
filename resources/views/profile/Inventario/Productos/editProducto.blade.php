<!-- resources/views/profile/Inventario/productos/editProducto.blade.php -->
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

                <!-- Código -->
                <div>
                    <label for="codigo" class="block text-gray-700 font-semibold">Código</label>
                    <input type="text" id="codigo" name="codigo" value="{{ $producto->codigo }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" readonly />
                </div>

                <!-- Nombre -->
                <div class="mt-4">
                    <label for="nombre" class="block text-gray-700 font-semibold">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="{{ $producto->nombre }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required />
                </div>

                <!-- Precio -->
                <div class="mt-4">
                    <label for="precio" class="block text-gray-700 font-semibold">Precio</label>
                    <input type="number" id="precio" name="precio" value="{{ $producto->precio }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required step="0.01" />
                </div>

                <!-- Fecha de Publicación -->
                <div class="mt-4">
                    <label for="fecha_de_publicacion" class="block text-gray-700 font-semibold">Fecha de Publicación</label>
                    <input type="date" id="fecha_de_publicacion" name="fecha_de_publicacion" value="{{ $producto->fecha_de_publicacion }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required />
                </div>

                <!-- Editorial -->
                <div class="mt-4">
                    <label for="editoriale_id" class="block text-gray-700 font-semibold">Editorial</label>
                    <input type="text" id="editoriale_id" name="editoriale_id" value="{{ $producto->editoriale_id }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" required />
                </div>

                <!-- Tipo de Producto -->
                <div class="mt-4">
                    <label for="producto_tipo" class="block text-gray-700 font-semibold">Tipo de Producto</label>
                    <select name="producto_tipo" id="producto_tipo" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" >
                        <option value="LIBRO" {{ $producto->producto_tipo === 'LIBRO' ? 'selected' : '' }}>Libro</option>
                        <option value="REVISTA" {{ $producto->producto_tipo === 'REVISTA' ? 'selected' : '' }}>Revista</option>
                        <option value="ENCICLOPEDIA" {{ $producto->producto_tipo === 'ENCICLOPEDIA' ? 'selected' : '' }}>Enciclopedia</option>
                    </select>
                </div>

                <!-- Campos adicionales según el tipo de producto -->
                @if ($producto->producto_tipo === 'LIBRO' && $tipo)
                    <div id="fields_libro" class="mt-4">
                        <!-- Autores -->
                        <label for="autores" class="block text-gray-700 font-semibold">Autores</label>
                        <input type="text" id="autores" name="autores" value="{{ $tipo->autores->pluck('nombre')->join(', ') }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" />

                        <!-- Tipo de Tapa -->
                        <label for="tipo_de_tapa" class="block text-gray-700 font-semibold mt-4">Tipo de Tapa</label>
                        <input type="text" id="tipo_de_tapa" name="tipo_de_tapa" value="{{ $tipo->tipo_de_tapa }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" />

                        <!-- Edición -->
                        <label for="edicion_libro" class="block text-gray-700 font-semibold mt-4">Edición</label>
                        <input type="number" id="edicion_libro" name="edicion_libro" value="{{ $tipo->Edicion }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" />
                    </div>
                @elseif ($producto->producto_tipo === 'REVISTA' && $tipo)
                    <div id="fields_revista" class="mt-4">
                        <!-- Número de Revista -->
                        <label for="nro" class="block text-gray-700 font-semibold">Número de Revista</label>
                        <input type="number" id="nro" name="nro" value="{{ $tipo->nro }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" />
                    </div>
                @elseif ($producto->producto_tipo === 'ENCICLOPEDIA' && $tipo)
                    <div id="fields_enciclopedia" class="mt-4">
                        <!-- Volumen -->
                        <label for="volumen" class="block text-gray-700 font-semibold">Volumen</label>
                        <input type="number" id="volumen" name="volumen" value="{{ $tipo->volumen }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" />

                        <!-- Edición -->
                        <label for="edicion_enciclopedia" class="block text-gray-700 font-semibold mt-4">Edición</label>
                        <input type="number" id="edicion_enciclopedia" name="edicion_enciclopedia" value="{{ $tipo->edicion }}" class="block mt-1 w-full p-2 border border-gray-300 rounded-lg" />
                    </div>
                @endif

                <!-- Género -->
                <div class="mt-4">
                    <label for="genero" class="block text-gray-700 font-semibold">Género</label>
                    <select name="generos[]" id="genero" multiple required class="block mt-1 w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        @foreach ($generos as $genero)
                            <option value="{{ $genero->id }}" {{ $producto->generos->contains($genero->id) ? 'selected' : '' }}>
                                {{ $genero->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botón Guardar -->
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('producto.index') }}" class="px-4 py-2 mr-2 text-gray-600 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">Cancelar</a>
                    <x-primary-button class="ms-4">
                        {{ __('Guardar Cambios') }}
                    </x-primary-button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
