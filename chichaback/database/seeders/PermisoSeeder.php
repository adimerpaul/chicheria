<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//<<<<<<< HEAD
        DB::table('permisos')->insert([
            ['nombre'=>'Controlar usuarios'],
            ['nombre'=>'Controlar clientes'],
            ['nombre'=>'Controlar productos'],
            ['nombre'=>'Controlar inventario'],
            ['nombre'=>'Venta detalle'],
            ['nombre'=>'Ver historial detalle'],
            ['nombre'=>'Venta local'],
            ['nombre'=>'Ver historial local'],
            ['nombre'=>'Controlar empleados'],
            ['nombre'=>'Reporte empleados'],
            ['nombre'=>'Controlar gastos'],
        ]);
//=======
//        //
//        DB::table('permisos')->insert([
//            ["nombre"=>"Clientes"],
//            ["nombre"=>"Productos"],
//            ["nombre"=>"Inventarios"],
//            ["nombre"=>"Venta Detalle"],
//            ["nombre"=>"Venta Local"],
//            ["nombre"=>"Empleado"],
//            ["nombre"=>"Reporte Usuario"],
//            ["nombre"=>"Reporte Ventas"],
//            ["nombre"=>"Reporte Prestamo"],
//            ["nombre"=>"Gastos"],
//            ["nombre"=>"Usuarios"],
//
//            ["nombre"=>"Registrar Cliente"],
//            ["nombre"=>"Modificar Cliente"],
//            ["nombre"=>"Eliminar Cliente"],
//            ["nombre"=>"Estado Cliente"],
//            ["nombre"=>"Registrar Producto"],
//            ["nombre"=>"Modificar Producto"],
//            ["nombre"=>"Eliminar Producto"],
//            ["nombre"=>"Registrar Material"],
//            ["nombre"=>"Modificar Material"],
//            ["nombre"=>"Eliminar Material"],
//            ["nombre"=>"Agregar Material"],
//            ["nombre"=>"Disminuir Material"],
//            ["nombre"=>"Registrar Prestamo"],
//            ["nombre"=>"Registrar Empleado"],
//            ["nombre"=>"Modificar Empleado"],
//            ["nombre"=>"Eliminar Empleado"],
//            ["nombre"=>"Agregar Sueldo"],
//            ["nombre"=>"Registrar Gasto"],
//            ["nombre"=>"Modificar Gasto"],
//            ["nombre"=>"Eliminar Gasto"],
//            ["nombre"=>"Registrar Usuario"],
//            ["nombre"=>"Modificar Usuario"],
//            ["nombre"=>"Cambiar Password"],
//            ["nombre"=>"Cambiar Permisos"],
//            ["nombre"=>"Eliminar Usuario"],
//         ]);
//>>>>>>> a64c39b0b8007f2636b9bda84ee6276a638bee19
    }
}
