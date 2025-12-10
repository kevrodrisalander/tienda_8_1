<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatProvedoresSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_provedores')->insert([
            ['id' => 1, 'nombre' => 'Distribuidora Samsung', 'descripcion' => 'Electrónica y electrodomésticos'],
            ['id' => 2, 'nombre' => 'Nike México', 'descripcion' => 'Ropa y calzado deportivo'],
            ['id' => 3, 'nombre' => 'LG Distribución', 'descripcion' => 'Pantallas y línea blanca'],
            ['id' => 4, 'nombre' => 'Adidas Proveedor', 'descripcion' => 'Accesorios deportivos'],
            ['id' => 5, 'nombre' => 'Whirlpool México', 'descripcion' => 'Electrodomésticos de cocina'],
            ['id' => 6, 'nombre' => 'Sony Distribuciones', 'descripcion' => 'Tecnología y audio'],
            ['id' => 7, 'nombre' => 'Panasonic México', 'descripcion' => 'Electrónica y hogar'],
            ['id' => 8, 'nombre' => 'Puma Distribuidor', 'descripcion' => 'Moda deportiva'],
            ['id' => 9, 'nombre' => 'Electrolux México', 'descripcion' => 'Electrodomésticos premium'],
            ['id' => 10, 'nombre' => 'Reebok Proveedor', 'descripcion' => 'Calzado y ropa deportiva'],
        ]);
    }
}
