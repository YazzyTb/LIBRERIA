<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Privilegio;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $privilegios = [
            ['nombre' => 'Ventas', 'descripcion' =>'Permite al usuario visualizar la interfaz de las ventas y realizar ventas de los productos existentes'],
            ['nombre' => 'Almacen(visualización)', 'descripcion' =>'Permite al usuario visualizar la interfaz de los productos existentes en la base de datos'],
            ['nombre' => 'Almacen', 'descripcion' =>'Permite al usuario visualizar, alterar, agregar y eliminar todos los productos que existentes en la base de datos'],
            ['nombre' => 'Clientes(visualización)', 'descripcion' =>'Permite al usuario visualizar la interfaz de los clientes registrados como clientes frucuentes'],
            ['nombre' => 'Clientes', 'descripcion' =>'Permite al usuario visualizar y registrar a nuevos clientes como clientes frecuentes'],
            ['nombre' => 'Proveedores(Pedidos)', 'descripcion' =>'Permite al usuario visualizar y realizar pedidos a todo proveedor que se encuentre en la base de datos'],
            ['nombre' => 'Proveedores', 'descripcion' =>'Permite al usuario visualizar, alterar, agregar y eliminar a los proveedores guardados en la base de datos ademas de realizar pedidos'],
            ['nombre' => 'Empleados', 'descripcion' =>'Permite al usuario visualizar, alterar, agregar y eliminar a los empleado en la base de datos'],
            ['nombre' => 'Roles', 'descripcion' =>'Permite al usuario visualizar, alterar, agregar y eliminar los roles que se asignaran a los empleados'],
            ['nombre' => 'Bitacora', 'descripcion' =>'Permite al usuario visualizar, alterar y eliminar la bitacora con los movimietos realizados por los empleados en la base de datos'],
            ['nombre' => 'finanzas', 'descripcion' =>'Permite al usuario visualizar, alterar, agregar y eliminar las transacciones realizadas en las compras y ventas de los productos en la base de datos'],
            ['nombre' => 'Promociones', 'descripcion' =>'Permite al usuario visualizar, alterar, agregar, crear y eliminar promociones que brindara la libreria']
        ];

        foreach($privilegios as $privilegio){
            Privilegio::create($privilegio);
        }

        $role = Role::create([
            'nombre' => 'administrador',
            'descripcion' => 'administrador de la pagina no tiene ninguna restricción es el usuario root',
        ]);

        $role->privilegios()->sync([1,2,3,4,5,6,7,8,9,10,11,12]);

        User::create([
            'id' => 1234567,
            'name' => 'Administrador',
            'email' => 'administrador@gmail.com',
            'password' => Hash::make(123456789),
            'role_id' => 1,
        ]);

        DB::table('acciones')->insert([
            [
                'operacion' => 'insert',
                'descripcion' => 'Acción que permite agregar nuevos registros en la tabla, registrando los datos iniciales de la operación. Generalmente utilizada para almacenar datos de nuevos usuarios, productos o cualquier entidad manejada por el sistema.',
            ],
            [
                'operacion' => 'update',
                'descripcion' => 'Acción que permite modificar los datos de un registro existente en la tabla, permitiendo cambios parciales o completos. Ideal para actualizar información de usuarios, cambiar el estado de un registro o modificar cualquier dato que lo necesite.',
            ],
            [
                'operacion' => 'delete',
                'descripcion' => 'Acción que permite eliminar un registro específico en la tabla, generalmente para mantener la consistencia y evitar datos obsoletos en el sistema. Esta acción suele ser irreversible y debe manejarse con precaución.',
            ],
        ]);
    }
}
