<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTipoProductoSeeder extends Seeder
{
    public function run()
    {
        // Elimina todos los registros de la tabla y reinicia el contador de auto-incremento
        DB::table('cat_tipo_producto')->truncate();

        // Ahora puedes insertar los nuevos registros
        DB::table('cat_tipo_producto')->insert([
            ['nombre' => 'Alimento', 'descripcion' => 'Productos comestibles'],
            ['nombre' => 'Ropa', 'descripcion' => 'Vestimenta y accesorios'],
            ['nombre' => 'Hogar', 'descripcion' => 'Artículos para el hogar'],
        ]);
    }
}


