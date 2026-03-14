<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatMarcasSeeder extends Seeder
{
    public function run()
    {
        // Inserta marcas sin depender de proveedores
        DB::table('cat_marcas')->insert([
            ['nombre' => 'Samsung', 'tipo' => 'Electrónica', 'descripcion' => 'Tecnología y electrodomésticos', 'fecha_registro' => now()],
            ['nombre' => 'Nike', 'tipo' => 'Deportes', 'descripcion' => 'Ropa y calzado deportivo', 'fecha_registro' => now()],
            ['nombre' => 'LG', 'tipo' => 'Pantallas', 'descripcion' => 'Electrónica y línea blanca', 'fecha_registro' => now()],
            ['nombre' => 'Adidas', 'tipo' => 'Deportes', 'descripcion' => 'Moda deportiva', 'fecha_registro' => now()],
            ['nombre' => 'Whirlpool', 'tipo' => 'Hogar', 'descripcion' => 'Electrodomésticos de cocina', 'fecha_registro' => now()],
            ['nombre' => 'Sony', 'tipo' => 'Audio', 'descripcion' => 'Tecnología y entretenimiento', 'fecha_registro' => now()],
            ['nombre' => 'Panasonic', 'tipo' => 'Hogar', 'descripcion' => 'Electrónica y línea blanca', 'fecha_registro' => now()],
            ['nombre' => 'Puma', 'tipo' => 'Moda', 'descripcion' => 'Ropa y accesorios deportivos', 'fecha_registro' => now()],
            ['nombre' => 'Electrolux', 'tipo' => 'Hogar', 'descripcion' => 'Electrodomésticos premium', 'fecha_registro' => now()],
            ['nombre' => 'Reebok', 'tipo' => 'Deportes', 'descripcion' => 'Calzado y ropa deportiva', 'fecha_registro' => now()],
        ]);
    }
}
