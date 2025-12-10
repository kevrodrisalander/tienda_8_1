<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatEstatusInventarioSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_estatus_inventario')->insert([
            [
                'id' => 1,
                'tipo' => 'Disponible',
                'activo' => true,
                'created_at' => '2024-03-08 10:49:06',
                'modified_at' => null,
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'tipo' => 'Apartado x',
                'activo' => true,
                'created_at' => '2024-03-08 10:49:06',
                'modified_at' => null,
                'deleted_at' => null
            ]
        ]);
    }
}
