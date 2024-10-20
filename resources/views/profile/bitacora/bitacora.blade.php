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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100" >
            
            @include('layouts.sidebar')

            <!-- Page Content -->
            <main>
                <div class="flex">
                    <!-- Sidebar -->
                    <div class="w-1/5 bg-white-200 p-4" >
                        
                    </div>
                    
                    <!-- Contenido principal -->
                    <div class="w-3/4 p-4">
                        <h1 class="text-2xl font-semibold mb-4">Bitácora</h1>
                        <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">ID</th>
                                    <th class="px-4 py-2">Tabla Afectada</th>
                                    <th class="px-4 py-2">Acción Realizada</th>
                                    <th class="px-4 py-2">Usuario</th>
                                    <th class="px-4 py-2">Fecha y Hora</th>
                                    <th class="px-4 py-2">Datos Anteriores</th>
                                    <th class="px-4 py-2">Datos Nuevos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bitacora as $registro)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $registro->id }}</td>
                                        <td class="border px-4 py-2">{{ $registro->tabla_Afectada }}</td>
                                        <td class="border px-4 py-2">{{ $registro->Accion_realizad }}</td>
                                        <td class="border px-4 py-2">{{ $registro->Usuario }}</td>
                                        <td class="border px-4 py-2">{{ $registro->Fecha_Hora }}</td>
                                        <td class="border px-4 py-2">{{ $registro->Datos_Anteriores }}</td>
                                        <td class="border px-4 py-2">{{ $registro->Datos_Nuevos }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
