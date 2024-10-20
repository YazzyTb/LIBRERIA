<x-app-layout>
    <div class="mt-8 text-center">
        <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-green-600 text-white font-bold text-lg rounded-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
            Registrar
        </a>
        <a href="{{ route('empleados') }}" class="inline-block px-8 py-3 bg-green-600 text-white font-bold text-lg rounded-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
            Alterar
        </a>
    </div>
    
</x-app-layout>