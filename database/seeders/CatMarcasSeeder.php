<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatMarcasSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_marcas')->insert([
            ['id' => 1, 'nombre' => 'Samsung', 'tipo' => 'Electrónica', 'descripcion' => 'Tecnología y electrodomésticos', 'provedor_id' => 1, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 2, 'nombre' => 'Nike', 'tipo' => 'Deportes', 'descripcion' => 'Ropa y calzado deportivo', 'provedor_id' => 2, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 3, 'nombre' => 'LG', 'tipo' => 'Pantallas', 'descripcion' => 'Electrónica y línea blanca', 'provedor_id' => 3, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 4, 'nombre' => 'Adidas', 'tipo' => 'Deportes', 'descripcion' => 'Moda deportiva', 'provedor_id' => 4, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 5, 'nombre' => 'Whirlpool', 'tipo' => 'Hogar', 'descripcion' => 'Electrodomésticos de cocina', 'provedor_id' => 5, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 6, 'nombre' => 'Sony', 'tipo' => 'Audio', 'descripcion' => 'Tecnología y entretenimiento', 'provedor_id' => 6, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 7, 'nombre' => 'Panasonic', 'tipo' => 'Hogar', 'descripcion' => 'Electrónica y línea blanca', 'provedor_id' => 7, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 8, 'nombre' => 'Puma', 'tipo' => 'Moda', 'descripcion' => 'Ropa y accesorios deportivos', 'provedor_id' => 8, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 9, 'nombre' => 'Electrolux', 'tipo' => 'Hogar', 'descripcion' => 'Electrodomésticos premium', 'provedor_id' => 9, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 10, 'nombre' => 'Reebok', 'tipo' => 'Deportes', 'descripcion' => 'Calzado y ropa deportiva', 'provedor_id' => 10, 'fecha_registro' => '2025-10-02 14:52:44'],
            ['id' => 11, 'nombre' => 'mora', 'tipo' => 'Ropa', 'descripcion' => null, 'provedor_id' => null, 'fecha_registro' => '2025-10-08 01:13:36'],
            ['id' => 12, 'nombre' => 'La huerta', 'tipo' => 'Verduras', 'descripcion' => null, 'provedor_id' => null, 'fecha_registro' => '2025-10-08 01:31:54'],
        ]);
    }
}
