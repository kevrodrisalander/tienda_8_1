<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTipoProductoSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_tipo_producto')->insert([
            ['id' => 1, 'nombre' => 'Alimento', 'descripcion' => 'Productos comestibles'],
            ['id' => 2, 'nombre' => 'Ropa', 'descripcion' => 'Vestimenta y accesorios'],
            ['id' => 3, 'nombre' => 'Hogar', 'descripcion' => 'Artículos para el hogar'],
        ]);
    }
}
