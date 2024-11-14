<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts y Scripts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.sidebar')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-1/5"></aside>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-semibold mb-4">Ventas</h1>

            <form method="POST" action="{{ route('venta.store') }}">
                @csrf

                <!-- Selección de productos y cantidades -->
                <div id="product-list">
                    <div class="product-item mb-4 flex space-x-4">
                        <div>
                            <label for="productos_array[]">Producto:</label>
                            <select name="productos_array[]" class="block w-full border-gray-300 rounded-md" onchange="updatePrice(this)">
                                <option value="">Seleccione un producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->codigo }}" data-precio="{{ $producto->precio }}">
                                        {{ $producto->nombre }} (Stock: {{ $producto->stocks->cantidad ?? 'No disponible' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="cantidad_array[]">Cantidad:</label>
                            <input type="number" name="cantidad_array[]" class="block w-full border-gray-300 rounded-md" min="1" value="1" oninput="updateTotal()">
                        </div>

                        <div>
                            <label>Precio:</label>
                            <input type="text" class="precio block w-full border-gray-300 rounded-md" readonly>
                        </div>

                        <button type="button" onclick="removeProduct(this)" class="mt-6 bg-red-500 text-white px-4 py-2 rounded-lg">Eliminar</button>
                    </div>
                </div>

                <!-- Botón para añadir más productos -->
                <button type="button" onclick="addProduct()" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4">Añadir otro producto</button>

                <!-- Total -->
                <div class="mt-4">
                    <label>Total:</label>
                    <input type="text" id="total" class="block w-full border-gray-300 rounded-md" readonly>
                </div>

                <!-- Formato de Pago -->
                <div class="mt-4">
                    <label for="formato_pago">Formato de Pago:</label>
                    <select name="formato_pago" class="block w-full border-gray-300 rounded-md" required>
                        <option value="0">Efectivo</option>
                        <option value="1">Tarjeta</option>
                    </select>
                </div>

                <!-- Campo para CI del Cliente -->
                <div class="mt-4">
                    <label for="cliente_ci">CI del Cliente:</label>
                    <input type="text" name="cliente_ci" class="block w-full border-gray-300 rounded-md">
                </div>

                <!-- Campo para Nombre del Cliente -->
                <div class="mt-4">
                    <label for="cliente_nombre">Nombre del Cliente:</label>
                    <input type="text" name="cliente_nombre" class="block w-full border-gray-300 rounded-md">
                </div>

                <!-- Botón para guardar la venta -->
                <button type="submit" class="mt-6 bg-green-500 text-white px-6 py-2 rounded-lg">Registrar Venta</button>
            </form>
        </main>
    </div>

    <script>
        function addProduct() {
            const productItem = document.querySelector('.product-item').cloneNode(true);
            document.getElementById('product-list').appendChild(productItem);
            updateTotal();
        }

        function removeProduct(button) {
            button.closest('.product-item').remove();
            updateTotal();
        }

        function updatePrice(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const priceField = selectElement.closest('.product-item').querySelector('.precio');
            const price = selectedOption.getAttribute('data-precio');
            priceField.value = price ? `$${price}` : '';
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.product-item').forEach(item => {
                const selectElement = item.querySelector('select');
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
                const quantity = parseInt(item.querySelector('input[name="cantidad_array[]"]').value) || 1;
                total += price * quantity;
            });
            document.getElementById('total').value = `$${total.toFixed(2)}`;
        }
    </script>
</body>
</html>
