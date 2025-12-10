<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatCategoriasSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_categorias')->insert([
            ['id' => 1, 'categoria' => 'Electronica', 'fecha' => '2024-05-12 23:55:39'],
            ['id' => 2, 'categoria' => 'Ropa', 'fecha' => '2024-05-12 23:55:39'],
            ['id' => 3, 'categoria' => 'Hogar', 'fecha' => '2024-05-12 23:55:39'],
            ['id' => 4, 'categoria' => 'Juguetes', 'fecha' => '2025-10-01 00:25:59'],
            ['id' => 5, 'categoria' => 'Deportes', 'fecha' => '2025-10-07 10:25:58'],
            ['id' => 6, 'categoria' => 'Oficina', 'fecha' => '2025-10-07 10:47:14'],
            ['id' => 7, 'categoria' => 'Frutas', 'fecha' => '2025-10-07 10:48:21'],
        ]);
    }
}
