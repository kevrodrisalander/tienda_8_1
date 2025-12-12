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
            ['id' => 3, 'codigo_lote' => '2025', 'fecha_ingreso' => '2025-11-03', 'cantidad' => 10],
            ['id' => 4, 'codigo_lote' => '2025', 'fecha_ingreso' => '2025-11-03', 'cantidad' => 5],
            ['id' => 5, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 40],
            ['id' => 6, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 20],
            ['id' => 7, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id' => 8, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id' => 9, 'codigo_lote' => 'F-2025', 'fecha_ingreso' => '2025-11-14', 'cantidad' => 100],
            ['id' => 10, 'codigo_lote' => 'F-12', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 100],
            ['id' => 11, 'codigo_lote' => 'F-50', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 50],
            ['id' => 12, 'codigo_lote' => 'Frutas-354sf', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id' => 13, 'codigo_lote' => 'fgdffdgh', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 5],
            ['id' => 14, 'codigo_lote' => 'ewrw', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id' => 15, 'codigo_lote' => 'sgsd', 'fecha_ingreso' => '2025-11-15', 'cantidad' => 10],
            ['id' => 16, 'codigo_lote' => 'd', 'fecha_ingreso' => '2025-12-08', 'cantidad' => 10],
            ['id' => 17, 'codigo_lote' => 'd', 'fecha_ingreso' => '2025-12-07', 'cantidad' => 10],
        ]);
    }
}
