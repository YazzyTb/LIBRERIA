
<link href="https://unpkg.com/flowbite@latest/dist/flowbite.min.css" rel="stylesheet">

@include('layouts.navigation')
<div class="flex h-full">
    
    <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-22 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
     </button>
 
    <aside id="sidebar-multi-level-sidebar" class="fixed left-0 top-0 z-40 w-64 h-screen mt-20 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50" style="background: #E7DED7;">
            <ul class="space-y-2 font-medium">
          <li>
             <a href="{{ route('bitacora.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black hover:bg-gray-100 ligth:hover:bg-gray-700 group">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-black">
                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                </svg>
             
                <span class="ms-3">Bitacora</span>
             </a>
          </li>
          <li x-data="{ open: false }">
            <button @click="open = !open" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">
                
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-black" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z" clip-rule="evenodd" />
                    </svg>

                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Usuarios</span>
                <svg class="w-3 h-3 transition-transform transform" :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul x-show="open" x-collapse class="py-2 space-y-2">
                <li>
                    <a href="{{ route('roles.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">Roles y Privilegios</a>
                </li>
                <li>
                    <a href="{{ route('empleados.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-Black ligth:hover:bg-gray-700">Empleados</a>
                </li>
                <li>
                    <a href="{{ route('clientes.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-Black ligth:hover:bg-gray-700">Clientes</a>
                </li>
            </ul>
        </li>
     {{-- <li>
             <a href="{{ route('usuarios.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black hover:bg-gray-100 ligth:hover:bg-gray-700 group">
                
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-black" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z" clip-rule="evenodd" />
                </svg>

                <span class="flex-1 ms-3 whitespace-nowrap">Usuarios</span>
             </a>
          </li> --}}    
          <li x-data="{ open: false }">
            <button @click="open = !open" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">
                
                <svg xmlns="http://www.w3.org/2000/svg"  class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-black" aria-hidden="true"  fill="currentColor" viewBox="0 0 24 24">
                <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>

                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Inventario</span>
                <svg class="w-3 h-3 transition-transform transform" :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul x-show="open" x-collapse class="py-2 space-y-2">
                <li>
                    <a href="{{ route('producto.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">Productos</a>
                </li>
            </ul>
        </li>
        <li x-data="{ open: false }">
            <button @click="open = !open" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">
                
                    <svg xmlns="http://www.w3.org/2000/svg"class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-black" aria-hidden="true"  fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                    <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
                    </svg>

                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Transacciones</span>
                <svg class="w-3 h-3 transition-transform transform" :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul x-show="open" x-collapse class="py-2 space-y-2">
                <li>
                    <a href="{{ route('venta.create') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-Black ligth:hover:bg-gray-700">Venta</a>
                </li>
                
                <li>
                    <a href="{{ route('ganancia_diaria.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">Reporte de pagos</a>
                </li>
                <li>
                    <a href="{{ route('facturas.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-Black ligth:hover:bg-gray-700">Facturas</a>
                </li>
                <li>
                    <a href="{{ route('proveedor.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">Proveedor</a>
                </li>
                <li>
                    <a href="{{ route('compra.index') }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-Black ligth:hover:bg-gray-700">Compra</a>
                </li>
               
                
            </ul>
        </li>
        <li x-data="{ open: false }">
            <button @click="open = !open" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">
                
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-black" aria-hidden="true"  fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z" />
                    <path d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z" />
                    <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                    </svg>

                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Promocion</span>
                <svg class="w-3 h-3 transition-transform transform" :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <ul x-show="open" x-collapse class="py-2 space-y-2">
                <li>
                    <a href="{{ route('promocion_producto.index') }}"  class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-black ligth:hover:bg-gray-700">Promocion</a>
                </li>
            </ul>
        </li>    
       </ul>
    </div>
 </aside>
</div>
<!-- Sidebar -left -->

<script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>