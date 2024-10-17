<x-sidebar-layouts>
<div class="flex">
    <!-- Sidebar -->
    

    <!-- Contenido principal -->
    <div class="w-3/4">
        <h1>Bitácora</h1>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tabla Afectada</th>
                    <th>Acción Realizada</th>
                    <th>Usuario</th>
                    <th>Fecha y Hora</th>
                    <th>Datos Anteriores</th>
                    <th>Datos Nuevos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bitacora as $registro)
                    <tr>
                        <td>{{ $registro->id }}</td>
                        <td>{{ $registro->tabla_Afectada }}</td>
                        <td>{{ $registro->Accion_realizad }}</td>
                        <td>{{ $registro->Usuario }}</td>
                        <td>{{ $registro->Fecha_Hora }}</td>
                        <td>{{ $registro->Datos_Anteriores }}</td>
                        <td>{{ $registro->Datos_Nuevos }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-sidebar-layouts>