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
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Empleado</h1>

            <!-- Formulario de Edición de Empleado -->
            <form method="POST" action="{{ route('empleados.update', $empleado->id) }}" class="space-y-6 bg-white p-8 shadow-md rounded-lg max-w-lg mx-auto">
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
                    <input type="number" name="id" value="{{ old('id', $empleado->id) }}" class="mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <x-input-error :messages="$errors->get('id')" class="mt-2" />
                </div>

                <!-- Campo de Nombre -->
                <div class="flex flex-col">
                    <label for="nombre" class="text-gray-700 font-semibold">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $empleado->name) }}" class="mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Campo de Email -->
                <div class="flex flex-col">
                    <label for="email" class="text-gray-700 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $empleado->email) }}" class="mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Campo de Rol -->
                <div class="flex flex-col">
                    <label for="role" class="text-gray-700 font-semibold">Rol</label>
                    <select name="role_id" id="role" class="mt-1 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="" disabled selected>Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $empleado->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
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
