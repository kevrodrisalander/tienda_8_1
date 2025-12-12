<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTipoMovimientoSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_tipo_movimiento')->insert([
            ['nombre' => 'Ingreso', 'descripcion' => 'Movimiento de entrada de recursos'],
            ['nombre' => 'Egreso', 'descripcion' => 'Movimiento de salida de recursos'],
            ['nombre' => 'Transferencia', 'descripcion' => 'Movimiento entre cuentas internas'],
            ['nombre' => 'Entrada por compra', 'descripcion' => 'Ingreso de productos adquiridos a proveedores'],
            ['nombre' => 'Salida por venta', 'descripcion' => 'Egreso de productos vendidos a clientes'],
            ['nombre' => 'Entrada por devolución', 'descripcion' => 'Ingreso de productos devueltos por clientes'],
            ['nombre' => 'Salida por merma', 'descripcion' => 'Egreso por pérdida, daño o caducidad de productos'],
            ['nombre' => 'Transferencia interna', 'descripcion' => 'Movimiento entre ubicaciones dentro de la empresa'],
            ['nombre' => 'Ajuste de inventario', 'descripcion' => 'Corrección manual por diferencias en el inventario'],
        ]);
    }
}

