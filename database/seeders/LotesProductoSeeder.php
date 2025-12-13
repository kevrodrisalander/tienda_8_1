<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotesProductoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lotes_producto')->insert([
            ['id_lote' => 1, 'codigo_lote' => 'jhb', 'fecha_ingreso' => '2025-11-02', 'cantidad' => 20],
            ['id_lote' => 2, 'codigo_lote' => 'o', 'fecha_ingreso' => '2025-11-02', 'cantidad' => 20],
            ['id_lote' => 3, 'codigo_lote' => '2025', 'fecha_ingreso' => '2025-11-03', 'cantidad' => 10],
            ['id_lote' => 4, 'codigo_lote' => '2025', 'fecha_ingreso' => '2025-11-03', 'cantidad' => 5],
            ['id_lote' => 5, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 40],
            ['id_lote' => 6, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 20],
            ['id_lote' => 7, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id_lote' => 8, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id_lote' => 9, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id_lote' => 10, 'codigo_lote' => 'F-12', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 100],
            ['id_lote' => 11, 'codigo_lote' => 'F-50', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 50],
            ['id_lote' => 12, 'codigo_lote' => 'Frutas-354sf', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id_lote' => 13, 'codigo_lote' => 'fgdffdgh', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 5],
            ['id_lote' => 14, 'codigo_lote' => 'ewrw', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id_lote' => 15, 'codigo_lote' => 'sgsd', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id_lote' => 16, 'codigo_lote' => 'd', 'fecha_ingreso' => '2025-12-08', 'cantidad' => 10],
            ['id_lote' => 17, 'codigo_lote' => 'd', 'fecha_ingreso' => '2025-12-07', 'cantidad' => 10],
        ]);
    }
}
