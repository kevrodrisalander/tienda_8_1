<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{

    public function run(): void
    {
        // Elimina todos los registros y reinicia el contador de auto-incremento
        DB::table('productos')->truncate();

        DB::table('productos')->insert([
            [
                'descripcion' => 'Manzana roja',
                'stock' => 0,
                'precio_venta' => 2,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/LDZb4dCayZdxVrUCoZdYfq8AVSGYSMki0jmlyf5v.png',
                'fecha' => '2025-11-02 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Manzana verde',
                'stock' => 0,
                'precio_venta' => 2,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/KVIGBwtgTtmcSEHqYGIYdjegVnp276Sm9vEyDDc2.jpg',
                'fecha' => '2025-11-03 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Sandia',
                'stock' => 0,
                'precio_venta' => 20,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/AUHncd2Vd5etImwYfSkLkWNRkaZlWcVtwP0OasoX.jpg',
                'fecha' => '2025-11-14 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Uva verde',
                'stock' => 0,
                'precio_venta' => 20,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/i7eRKCsBngWJGOFxP10Ic6uT8DxxVGSmw6hcPMrt.jpg',
                'fecha' => '2025-11-14 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Durazno',
                'stock' => 0,
                'precio_venta' => 20,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/0aToA2PpQFDA02MbUTjxkqoCqlsFLUI9yCpI2k3U.jpg',
                'fecha' => '2025-11-14 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Fresa',
                'stock' => 0,
                'precio_venta' => 10,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/duA1JjxJ3SwgrQBruHwtQJ7h2zkYNCfoAbw7iGQs.jpg',
                'fecha' => '2025-11-14 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Cereza',
                'stock' => 0,
                'precio_venta' => 10,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/cerezas.jpg',
                'fecha' => '2025-11-14 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Zanahorias',
                'stock' => 0,
                'precio_venta' => 2,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/xNVdj3Smdt4h3fOrxScxkLuFbqmz2RmI0yMgOSuI.jpg',
                'fecha' => '2025-11-15 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Tomate Verde',
                'stock' => 0,
                'precio_venta' => 5,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/4o4fwkSRmDqUCTBUmiZkkjHAkJmYntL5mB0vxfuq.jpg',
                'fecha' => '2025-11-15 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Papa blanca',
                'stock' => 0,
                'precio_venta' => 10,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/P8KKNyEfnGOnTdTnGQhQdZBVj75AhikmgTgwA766.jpg',
                'fecha' => '2025-11-15 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Ajo blanco',
                'stock' => 0,
                'precio_venta' => 2,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/UcyEKHpcclOeNhxSSeczauPhYNmxplXL6uZOZV22.webp',
                'fecha' => '2025-11-15 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Cebolla morada',
                'stock' => 0,
                'precio_venta' => 10,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/CSumgKvQKQW7SeBjjK2Ft2VcJGIiZNQrKGEI8l1g.jpg',
                'fecha' => '2025-11-15 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Cebolla blanca',
                'stock' => 0,
                'precio_venta' => 5,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/ESBKn92eU7ncEYijEFo95WYuUcKhPYj2i6OxXRh9.webp',
                'fecha' => '2025-11-15 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Camisa blanca',
                'stock' => 0,
                'precio_venta' => 50,
                'id_status' => 1,
                'id_categoria' => 2,
                'name_file' => 'productos/bdiaK4gQvceukB7u220I4FNmytSXmj9ZwIQCq5d2.jpg',
                'fecha' => '2025-11-03 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'moras pruebas',
                'stock' => 0,
                'precio_venta' => 1,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/khaQSRxlDLIefznhQfpeUEcGIG2fLYmYRdSHhQO9.jpg',
                'fecha' => '2025-12-07 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'Manzana amarilla',
                'stock' => 0,
                'precio_venta' => 1,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/xnK0eXCyjtkNjvl4tB7z5bYkemVhAvLEaZJR7Fln.jpg',
                'fecha' => '2025-11-02 00:00:00',
                'id_marca' => 12
            ],
            [
                'descripcion' => 'ajo 2',
                'stock' => 10,
                'precio_venta' => 5,
                'id_status' => 1,
                'id_categoria' => 7,
                'name_file' => 'productos/9AayVM4Z1RXMdeAKQdhLCvv0eGhBVp1zKZ3eHRzr.webp',
                'fecha' => '2025-12-07 00:00:00',
                'id_marca' => 12
            ],
        ]);
    }
}
