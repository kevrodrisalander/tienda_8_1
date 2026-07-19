<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatProvedoresSeeder extends Seeder
{
    public function run()
{
    // Elimina todos los registros y reinicia el contador del auto-incremento
    DB::table('cat_provedores')->truncate();

    // Inserta los nuevos registros
    DB::table('cat_provedores')->insert([
    ['descripcion' => 'Electrónica y electrodomésticos', 'nombre' => 'Distribuidora Samsung'],
    ['descripcion' => 'Ropa y calzado deportivo', 'nombre' => 'Nike México'],
    ['descripcion' => 'Pantallas y línea blanca', 'nombre' => 'LG Distribución'],
    ['descripcion' => 'Accesorios deportivos', 'nombre' => 'Adidas Proveedor'],
    ['descripcion' => 'Electrodomésticos de cocina', 'nombre' => 'Whirlpool México'],
    ['descripcion' => 'Tecnología y audio', 'nombre' => 'Sony Distribuciones'],
    ['descripcion' => 'Electrónica y hogar', 'nombre' => 'Panasonic México'],
    ['descripcion' => 'Moda deportiva', 'nombre' => 'Puma Distribuidor'],
    ['descripcion' => 'Electrodomésticos premium', 'nombre' => 'Electrolux México'],
    ['descripcion' => 'Calzado y ropa deportiva', 'nombre' => 'Reebok Proveedor'],

    ['descripcion' => 'Dispositivos móviles y computadoras', 'nombre' => 'Apple Distribuciones'],
    ['descripcion' => 'Ropa y accesorios deportivos', 'nombre' => 'Under Armour México'],
    ['descripcion' => 'Electrodomésticos y herramientas', 'nombre' => 'Bosch México'],
    ['descripcion' => 'Tecnología y hardware', 'nombre' => 'Dell Proveedor'],
    ['descripcion' => 'Impresoras y laptops', 'nombre' => 'HP México'],
    ['descripcion' => 'Hardware y laptops', 'nombre' => 'Asus Distribuidor'],
    ['descripcion' => 'PCs y dispositivos móviles', 'nombre' => 'Lenovo México'],
    ['descripcion' => 'Smartphones y tecnología', 'nombre' => 'Huawei Distribuciones'],
    ['descripcion' => 'Calzado deportivo', 'nombre' => 'New Balance México'],
    ['descripcion' => 'Electrodomésticos de cocina', 'nombre' => 'KitchenAid Proveedor'],
]);
}

}