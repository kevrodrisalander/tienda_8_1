<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSeccionesSeeder extends Seeder
{
    public function run()
    {
        // Limpiar la tabla antes de insertar nuevos registros
        DB::table('cat_secciones')->truncate();

        // Inserta las nuevas secciones
        DB::table('cat_secciones')->insert([
            ['nombre' => 'Electronica sec', 'descripcion' => 'Tecnología y gadgets', 'slug' => 'electronica'],
            ['nombre' => 'Ropa sec', 'descripcion' => 'Vestimenta y accesorios', 'slug' => 'ropa'],
            ['nombre' => 'Hogar sec', 'descripcion' => 'Artículos para el hogar', 'slug' => 'hogar'],
            ['nombre' => 'Juguetes sec', 'descripcion' => 'Entretenimiento infantil', 'slug' => 'juguetes'],
            ['nombre' => 'Deportes sec', 'descripcion' => 'Equipamiento deportivo', 'slug' => 'deportes'],
            ['nombre' => 'Oficina sec', 'descripcion' => 'Departamento de papeleria', 'slug' => 'oficina'],
            ['nombre' => 'Frutas y Verduras sec', 'descripcion' => 'Departamento de verduras y frutas', 'slug' => 'frutas'],
        ]);
    }
}

