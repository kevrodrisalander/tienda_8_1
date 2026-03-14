<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    public function run()
    {
        // Inserta proveedores usando el nombre de la marca para buscar el ID
        DB::table('proveedores')->insert([
            [
                'nombre' => 'Distribuidora Samsung',
                'contacto' => 'Laura Gómez',
                'telefono' => '555-1234',
                'email' => 'samsung@proveedor.com',
                'direccion' => 'Av. Reforma 123, CDMX',
                'id_cat_marcas' => DB::table('cat_marcas')->where('nombre','Samsung')->value('id'),
                'fecha_registro' => now(),
            ],
            [
                'nombre' => 'Nike México',
                'contacto' => 'Carlos Ruiz',
                'telefono' => '555-5678',
                'email' => 'nike@proveedor.com',
                'direccion' => 'Calle Hidalgo 456, Guadalajara',
                'id_cat_marcas' => DB::table('cat_marcas')->where('nombre','Nike')->value('id'),
                'fecha_registro' => now(),
            ],
            [
                'nombre' => 'LG Distribución',
                'contacto' => 'Ana Torres',
                'telefono' => '555-9012',
                'email' => 'lg@proveedor.com',
                'direccion' => 'Blvd. del Sur 789, Monterrey',
                'id_cat_marcas' => DB::table('cat_marcas')->where('nombre','LG')->value('id'),
                'fecha_registro' => now(),
            ],
            [
                'nombre' => 'Adidas Proveedor',
                'contacto' => 'Luis Pérez',
                'telefono' => '555-3456',
                'email' => 'adidas@proveedor.com',
                'direccion' => 'Av. Juárez 321, Puebla',
                'id_cat_marcas' => DB::table('cat_marcas')->where('nombre','Adidas')->value('id'),
                'fecha_registro' => now(),
            ],
            [
                'nombre' => 'Whirlpool México',
                'contacto' => 'María López',
                'telefono' => '555-7890',
                'email' => 'whirlpool@proveedor.com',
                'direccion' => 'Calle Morelos 654, Querétaro',
                'id_cat_marcas' => DB::table('cat_marcas')->where('nombre','Whirlpool')->value('id'),
                'fecha_registro' => now(),
            ],
            // ... agrega los demás proveedores de la misma forma
        ]);
    }
}
