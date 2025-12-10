<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSeccionesSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_secciones')->insert([
            ['id' => 1, 'nombre' => 'Electronica sec', 'descripcion' => 'Tecnología y gadgets', 'slug' => 'electronica'],
            ['id' => 2, 'nombre' => 'Ropa sec', 'descripcion' => 'Vestimenta y accesorios', 'slug' => 'ropa'],
            ['id' => 3, 'nombre' => 'Hogar sec', 'descripcion' => 'Artículos para el hogar', 'slug' => 'hogar'],
            ['id' => 4, 'nombre' => 'Juguetes sec', 'descripcion' => 'Entretenimiento infantil', 'slug' => 'juguetes'],
            ['id' => 5, 'nombre' => 'Deportes sec', 'descripcion' => 'Equipamiento deportivo', 'slug' => 'deportes'],
            ['id' => 6, 'nombre' => 'Oficina sec', 'descripcion' => 'Departamento de papeleria', 'slug' => 'oficina'],
            ['id' => 7, 'nombre' => 'Frutas y Verduras sec', 'descripcion' => 'Departamento de verduras y frutas', 'slug' => 'frutas'],
        ]);
    }
}
