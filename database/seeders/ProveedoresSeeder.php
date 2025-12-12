<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proveedores')->insert([
            [
                'id' => 1,
                'nombre' => 'Distribuidora Samsung',
                'contacto' => 'Laura Gómez',
                'telefono' => '555-1234',
                'email' => 'samsung@proveedor.com',
                'direccion' => 'Av. Reforma 123, CDMX',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 1
            ],
            [
                'id' => 2,
                'nombre' => 'Nike México',
                'contacto' => 'Carlos Ruiz',
                'telefono' => '555-5678',
                'email' => 'nike@proveedor.com',
                'direccion' => 'Calle Hidalgo 456, Guadalajara',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 2
            ],
            [
                'id' => 3,
                'nombre' => 'LG Distribución',
                'contacto' => 'Ana Torres',
                'telefono' => '555-9012',
                'email' => 'lg@proveedor.com',
                'direccion' => 'Blvd. del Sur 789, Monterrey',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 3
            ],
            [
                'id' => 4,
                'nombre' => 'Adidas Proveedor',
                'contacto' => 'Luis Pérez',
                'telefono' => '555-3456',
                'email' => 'adidas@proveedor.com',
                'direccion' => 'Av. Juárez 321, Puebla',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 4
            ],
            [
                'id' => 5,
                'nombre' => 'Whirlpool México',
                'contacto' => 'María López',
                'telefono' => '555-7890',
                'email' => 'whirlpool@proveedor.com',
                'direccion' => 'Calle Morelos 654, Querétaro',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 5
            ],
            [
                'id' => 6,
                'nombre' => 'Sony Distribuciones',
                'contacto' => 'Jorge Martínez',
                'telefono' => '555-4321',
                'email' => 'sony@proveedor.com',
                'direccion' => 'Av. Insurgentes 100, CDMX',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 6
            ],
            [
                'id' => 7,
                'nombre' => 'Panasonic México',
                'contacto' => 'Isabel Ramírez',
                'telefono' => '555-8765',
                'email' => 'panasonic@proveedor.com',
                'direccion' => 'Calle Independencia 200, León',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 7
            ],
            [
                'id' => 8,
                'nombre' => 'Puma Distribuidor',
                'contacto' => 'Fernando Salas',
                'telefono' => '555-6543',
                'email' => 'puma@proveedor.com',
                'direccion' => 'Blvd. Atlixco 300, Puebla',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 8
            ],
            [
                'id' => 9,
                'nombre' => 'Electrolux México',
                'contacto' => 'Patricia Vega',
                'telefono' => '555-3210',
                'email' => 'electrolux@proveedor.com',
                'direccion' => 'Av. Universidad 400, CDMX',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 9
            ],
            [
                'id' => 10,
                'nombre' => 'Reebok Proveedor',
                'contacto' => 'Ricardo Mendoza',
                'telefono' => '555-2109',
                'email' => 'reebok@proveedor.com',
                'direccion' => 'Calle Zaragoza 500, Toluca',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 10
            ],
            [
                'id' => 10,
                'nombre' => 'Reebok Proveedor',
                'contacto' => 'Ricardo Mendoza',
                'telefono' => '555-2109',
                'email' => 'reebok@proveedor.com',
                'direccion' => 'Calle Zaragoza 500, Toluca',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 11
            ],
            [
                'id' => 10,
                'nombre' => 'Reebok Proveedor',
                'contacto' => 'Ricardo Mendoza',
                'telefono' => '555-2109',
                'email' => 'reebok@proveedor.com',
                'direccion' => 'Calle Zaragoza 500, Toluca',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 12
            ],
            [
                'id' => 10,
                'nombre' => 'Reebok Proveedor',
                'contacto' => 'Ricardo Mendoza',
                'telefono' => '555-2109',
                'email' => 'reebok@proveedor.com',
                'direccion' => 'Calle Zaragoza 500, Toluca',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 13
            ],
            [
                'id' => 10,
                'nombre' => 'Reebok Proveedor',
                'contacto' => 'Ricardo Mendoza',
                'telefono' => '555-2109',
                'email' => 'reebok@proveedor.com',
                'direccion' => 'Calle Zaragoza 500, Toluca',
                'fecha_registro' => '2025-10-02 14:49:36.693',
                'id_cat_marcas' => 14
            ]
        ]);
    }
}
