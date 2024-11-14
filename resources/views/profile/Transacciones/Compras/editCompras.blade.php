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
<body class="font-sans antialiased bg-gray-50">
    <form action="{{ route('compra.update', $compra->nro) }}" method="POST">
        @csrf
        @method('PUT')
    
        
        @csrf
        
    <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" value="{{ old('fecha', $compra->fecha) }}" required>
    
        <label for="proveedore_id">Proveedor:</label>
        <select name="proveedore_id" required>
            @foreach($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}" {{ old('proveedore_id', $compra->proveedore_id) == $proveedor->id ? 'selected' : '' }}>
                    {{ $proveedor->nombre }}
                </option>
            @endforeach
        </select>
    
        <div id="productos">
            @foreach ($productosCompra as $producto)
                <div>
                    <input type="checkbox" name="productos[{{ $producto->pivot->producto_codigo }}][selected]" value="1" {{ old('productos.' . $producto->pivot->producto_codigo . '.selected', 1) ? 'checked' : '' }}>
                    <label>{{ $producto->nombre }}</label>
    
                    <input type="number" name="productos[{{ $producto->pivot->producto_codigo }}][cantidad]" value="{{ old('productos.' . $producto->pivot->producto_codigo . '.cantidad', $producto->pivot->cantidad) }}" placeholder="Cantidad" min="1" required>
                    <input type="number" step="0.01" name="productos[{{ $producto->pivot->producto_codigo }}][precio]" value="{{ old('productos.' . $producto->pivot->producto_codigo . '.precio', $producto->pivot->precio) }}" placeholder="Precio unitario" min="0" required>
    
                    <!-- Puedes añadir un botón para eliminar el producto si lo deseas -->
                    <button type="button" onclick="removeProduct({{ $producto->pivot->producto_codigo }})">Eliminar</button>
                </div>
            @endforeach
    
            <!-- Opción para agregar nuevos productos -->
            <div>
                <label>Agregar nuevo producto:</label>
                <select name="productos[nuevo_producto][producto_codigo]">
                    @foreach($stocks as $codigo)
                        <option value="{{ $codigo }}">{{ $codigo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    
        <button type="submit">Actualizar compra</button>
    </form>
</body>
</html>