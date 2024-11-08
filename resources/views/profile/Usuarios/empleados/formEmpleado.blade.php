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
            <h1 class="text-2xl font-semibold mb-4">Registrar Empleado</h1>
            
            
            <form method="POST" action="{{ route('empleados.store') }}">
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
                    <x-input-label for="id" :value="__('CI')" />
                    <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id')" required autofocus autocomplete="id" />
                    <x-input-error :messages="$errors->get('id')" class="mt-2" />
                </div>
        
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
        
                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

               <!-- Rol -->
               <div class="mt-4">
                <x-input-label for="role_id" :value="__('Rol')" />
                <select name="role_id" id="role_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <option value="" disabled selected>Seleccione un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->nombre }}">{{ $role->nombre }}</option>
                    @endforeach
                </select>
            </div>

        
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
        
                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
        
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
        
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
        
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    
        
                    <x-primary-button class="ms-4">
                        {{ __('Registrar') }}
                    </x-primary-button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>