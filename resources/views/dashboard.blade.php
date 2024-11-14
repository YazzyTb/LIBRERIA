<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" >
            {{ __('Athena') }} 
        </h2>     
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg" style="background-color: #E7DED7;">
                <div class="p-6 lg:p-8 border-b border-gray-200" style="background-color: #E7DED7;">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500 block mx-auto"/>
                    <h1 class="mt-8 text-2xl font-medium text-gray-900 block text-center">
                        Bienvenido a tu inventario Athena!!
                    </h1>
                
                    <p class="mt-6 text-gray-500 leading-relaxed text-center">
                        Somos tu inventario de confianza.
                    </p>
                </div>
                <div class="bg-gray-200 bg-opacity-25 gap-6 lg:gap-8 p-6 lg:p-8">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="relative max-w-xs overflow-hidden bg-cover bg-[50%] bg-no-repeat">
                             <a href="{{ route('empleados.index') }}">
                                 <img src="https://i0.wp.com/nuevodiario-assets.s3.us-east-2.amazonaws.com/wp-content/uploads/2024/10/01093938/Un-gran-numero-de-editoras-y-librerias-nacionales-y-extranjeras-estaran-en-la-Feria-del-Libro-2024-scaled.jpg?resize=1200%2C1200&quality=100&ssl=1" class="h-auto max-w-full rounded-lg"/>
                                <div class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-fixed rounded-lg"style="background-color: hsla(0, 0%, 0%, 0.4)">
                                    <div class="flex h-full items-center justify-center">
                                        <h1 class="text-white opacity-100 "> <strong>USUARIOS</strong></h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="relative max-w-xs overflow-hidden bg-cover bg-[50%] bg-no-repeat">
                            <a href="{{ route('producto.index') }}">
                                <img src="https://image.ondacero.es/clipping/cmsimages02/2019/11/07/996672A0-F0F6-4E33-8A6C-4CB4A383700D/104.jpg?crop=1280,1280,x337,y0&width=1200&height=1200&optimize=low&format=webply" class="h-auto max-w-full rounded-lg"/>
                               <div class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-fixed rounded-lg"style="background-color: hsla(0, 0%, 0%, 0.4)">
                                   <div class="flex h-full items-center justify-center">
                                       <h1 class="text-white opacity-100 "> <strong>INVENTARIO</strong></h1>
                                   </div>
                               </div>
                           </a>
                       </div>
                        
                       
                   <div class="relative max-w-xs overflow-hidden bg-cover bg-[50%] bg-no-repeat">
                    <a href="{{ route('venta.create') }}">
                        <img src="https://www.cripto247.com/.image/ar_1:1%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cq_auto:good%2Cw_1200/MTk4MTc5NDAyOTA3NTI2MjE2/eeuu-quiere-eximir-de-ganancias-a-las-transacciones-cripto.jpg"/>
                       <div class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-fixed rounded-lg"style="background-color: hsla(0, 0%, 0%, 0.4)">
                           <div class="flex h-full items-center justify-center">
                               <h1 class="text-white opacity-100 "> <strong>TRANSACCIONES</strong></h1>
                           </div>
                       </div>
                   </a>
                </div>
                <div class="relative max-w-xs overflow-hidden bg-cover bg-[50%] bg-no-repeat">
                    <a href="{{ route('promocion_producto.index') }}">
                        <img src="https://image.ondacero.es/clipping/cmsimages02/2020/08/04/352B5B0D-1B16-47F7-96CB-B14CFC3DED27/104.jpg?crop=1280,1280,x249,y0&width=1200&height=1200&optimize=low&format=webply" class="h-auto max-w-full rounded-lg"/>
                       <div class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-fixed rounded-lg"style="background-color: hsla(0, 0%, 0%, 0.4)">
                           <div class="flex h-full items-center justify-center">
                               <h1 class="text-white opacity-100 "> <strong>PROMOCIONES</strong></h1>
                           </div>
                       </div>
                   </a>
               </div>
                <div class="relative max-w-xs overflow-hidden bg-cover bg-[50%] bg-no-repeat">
                    <a href="{{ route('bitacora.index') }}">
                        <img src="https://www.cursosmusicales.es/wp-content/uploads/Untitled-2-5.png" class="h-auto max-w-full rounded-lg"/>
                       <div class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-fixed rounded-lg"style="background-color: hsla(0, 0%, 0%, 0.4)">
                           <div class="flex h-full items-center justify-center">
                               <h1 class="text-white opacity-100 "> <strong>BITACORA</strong></h1>
                           </div>
                       </div>
                   </a>
                </div>
                
            </div> 
        </div>
    </div>
</x-app-layout>
