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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 " style="background-image: url('/img/fondo.jpg'); background-repeat: repeat; background-size: 20%; ">
        
            
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-transparent bg-opacity-30 backdrop-blur-lg border-2 border-white/20 shadow-md overflow-hidden sm:rounded-lg " style="backdrop-filter: blur(8px);">
                <a href="/" >
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500 block mx-auto" />
                </a>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
