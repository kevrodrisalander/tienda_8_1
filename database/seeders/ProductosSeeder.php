<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'id' => 77,
                'descripcion' => 'Manzana roja',
                'stock' => 0,
                'precio_venta' => 2,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/LDZb4dCayZdxVrUCoZdYfq8AVSGYSMki0jmlyf5v.png',
                'fecha' => '2025-11-02 00:00:00',
                'id_marca' => 27
            ],
            [
                'id' => 78,
                'descripcion' => 'Manzana verde',
                'stock' => 0,
                'precio_venta' => 2,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/KVIGBwtgTtmcSEHqYGIYdjegVnp276Sm9vEyDDc2.jpg',
                'fecha' => '2025-11-03 00:00:00',
                'id_marca' => 27
            ],
            [
                'id' => 80,
                'descripcion' => 'Sandia',
                'stock' => 0,
                'precio_venta' => 20,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/AUHncd2Vd5etImwYfSkLkWNRkaZlWcVtwP0OasoX.jpg',
                'fecha' => '2025-11-14 00:00:00',
                'id_marca' => 27
            ],
            // Continúa con todos los demás productos siguiendo el mismo formato
        ]);
    }
}
