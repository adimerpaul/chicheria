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
        ]);
    }
}
