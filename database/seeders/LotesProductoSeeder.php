<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotesProductoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lotes_producto')->insert([
            ['id' => 1, 'codigo_lote' => 'jhb', 'fecha_ingreso' => '2025-11-02', 'cantidad' => 20],
            ['id' => 2, 'codigo_lote' => 'o', 'fecha_ingreso' => '2025-11-02', 'cantidad' => 20],
            ['id' => 36, 'codigo_lote' => '2025', 'fecha_ingreso' => '2025-11-03', 'cantidad' => 10],
            ['id' => 37, 'codigo_lote' => '2025', 'fecha_ingreso' => '2025-11-03', 'cantidad' => 5],
            ['id' => 38, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 40],
            ['id' => 39, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 20],
            ['id' => 40, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id' => 41, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id' => 42, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id' => 43, 'codigo_lote' => 'F-12', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 100],
            ['id' => 44, 'codigo_lote' => 'F-50', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 50],
            ['id' => 45, 'codigo_lote' => 'Frutas-354sf', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id' => 46, 'codigo_lote' => 'fgdffdgh', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 5],
            ['id' => 47, 'codigo_lote' => 'ewrw', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id' => 48, 'codigo_lote' => 'sgsd', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id' => 49, 'codigo_lote' => 'd', 'fecha_ingreso' => '2025-12-08', 'cantidad' => 10],
            ['id' => 50, 'codigo_lote' => 'd', 'fecha_ingreso' => '2025-12-07', 'cantidad' => 10],
            ['id' => 51, 'codigo_lote' => 'ajo', 'fecha_ingreso' => '2025-12-07', 'cantidad' => 10],
        ]);
    }
}
