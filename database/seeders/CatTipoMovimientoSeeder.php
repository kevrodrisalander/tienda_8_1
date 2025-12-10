<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTipoMovimientoSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_tipo_movimiento')->insert([
            ['id' => 1, 'nombre' => 'Ingreso', 'descripcion' => 'Movimiento de entrada de recursos'],
            ['id' => 2, 'nombre' => 'Egreso', 'descripcion' => 'Movimiento de salida de recursos'],
            ['id' => 3, 'nombre' => 'Transferencia', 'descripcion' => 'Movimiento entre cuentas internas'],
            ['id' => 4, 'nombre' => 'Entrada por compra', 'descripcion' => 'Ingreso de productos adquiridos a proveedores'],
            ['id' => 5, 'nombre' => 'Salida por venta', 'descripcion' => 'Egreso de productos vendidos a clientes'],
            ['id' => 6, 'nombre' => 'Entrada por devolución', 'descripcion' => 'Ingreso de productos devueltos por clientes'],
            ['id' => 7, 'nombre' => 'Salida por merma', 'descripcion' => 'Egreso por pérdida, daño o caducidad de productos'],
            ['id' => 8, 'nombre' => 'Transferencia interna', 'descripcion' => 'Movimiento entre ubicaciones dentro de la empresa'],
            ['id' => 9, 'nombre' => 'Ajuste de inventario', 'descripcion' => 'Corrección manual por diferencias en el inventario'],
        ]);
    }
}
