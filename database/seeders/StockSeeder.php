<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stock')->insert([
            [
                'id' => 10,
                'producto_id' => 80,
                'cantidad' => 40,
                'ubicacion' => 'Ciudad de Mexico',
                'estado' => 'disponible',
                'minimo_seguro' => 100,
                'maximo_permitido' => 500,
                'fecha_ingreso' => '2025-11-14 00:00:00',
                'fecha_vencimiento' => '2025-11-21',
                'lote' => '',
                'observaciones' => 'Sandia mx',
                'activo' => true,
                'tipo_movimiento' => 'entrada',
                'usuario_id' => null,
                'created_at' => '2025-11-14 17:30:21.503',
                'updated_at' => '2025-11-14 17:30:21.503',
                'id_lote' => 38
            ],
            [
                'id' => 11,
                'producto_id' => 81,
                'cantidad' => 20,
                'ubicacion' => 'Ciudad de México',
                'estado' => 'disponible',
                'minimo_seguro' => 10,
                'maximo_permitido' => 40,
                'fecha_ingreso' => '2025-11-14 00:00:00',
                'fecha_vencimiento' => '2025-11-14',
                'lote' => '',
                'observaciones' => 'Uva verde',
                'activo' => true,
                'tipo_movimiento' => 'entrada',
                'usuario_id' => null,
                'created_at' => '2025-11-14 17:32:08.614',
                'updated_at' => '2025-11-14 17:32:08.614',
                'id_lote' => 39
            ],
            [
                'id' => 12,
                'producto_id' => 82,
                'cantidad' => 100,
                'ubicacion' => 'Ciudad de México',
                'estado' => 'disponible',
                'minimo_seguro' => 10,
                'maximo_permitido' => 200,
                'fecha_ingreso' => '2025-11-14 00:00:00',
                'fecha_vencimiento' => '2025-11-14',
                'lote' => '',
                'observaciones' => 'x',
                'activo' => true,
                'tipo_movimiento' => 'entrada',
                'usuario_id' => null,
                'created_at' => '2025-11-14 17:46:44.901',
                'updated_at' => '2025-11-14 17:46:44.901',
                'id_lote' => 40
            ],
            // Aquí seguirías agregando los demás registros...
        ]);
    }
}
