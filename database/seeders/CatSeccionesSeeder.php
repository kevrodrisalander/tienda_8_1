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
        // DB::table('cat_secciones')->insert([
        //     ['nombre' => 'Electronica sec', 'descripcion' => 'Tecnología y gadgets', 'slug' => 'electronica'],
        //     ['nombre' => 'Ropa sec', 'descripcion' => 'Vestimenta y accesorios', 'slug' => 'ropa'],
        //     ['nombre' => 'Hogar sec', 'descripcion' => 'Artículos para el hogar', 'slug' => 'hogar'],
        //     ['nombre' => 'Juguetes sec', 'descripcion' => 'Entretenimiento infantil', 'slug' => 'juguetes'],
        //     ['nombre' => 'Deportes sec', 'descripcion' => 'Equipamiento deportivo', 'slug' => 'deportes'],
        //     ['nombre' => 'Oficina sec', 'descripcion' => 'Departamento de papeleria', 'slug' => 'oficina'],
        //     ['nombre' => 'Frutas y Verduras sec', 'descripcion' => 'Departamento de verduras y frutas', 'slug' => 'frutas'],
        // ]);
        DB::table('cat_secciones')->insert([
    ['nombre' => 'Electronica sec', 'descripcion' => 'Tecnología y gadgets', 'slug' => 'electronica'],
    ['nombre' => 'Ropa sec', 'descripcion' => 'Vestimenta y accesorios', 'slug' => 'ropa'],
    ['nombre' => 'Hogar sec', 'descripcion' => 'Artículos para el hogar', 'slug' => 'hogar'],
    ['nombre' => 'Juguetes sec', 'descripcion' => 'Entretenimiento infantil', 'slug' => 'juguetes'],
    ['nombre' => 'Deportes sec', 'descripcion' => 'Equipamiento deportivo', 'slug' => 'deportes'],
    ['nombre' => 'Oficina sec', 'descripcion' => 'Departamento de papeleria', 'slug' => 'oficina'],
    ['nombre' => 'Frutas y Verduras sec', 'descripcion' => 'Departamento de verduras y frutas', 'slug' => 'frutas'],

    // 10 adicionales
    ['nombre' => 'Automotriz sec', 'descripcion' => 'Accesorios y refacciones de autos', 'slug' => 'automotriz'],
    ['nombre' => 'Belleza sec', 'descripcion' => 'Cosméticos y cuidado personal', 'slug' => 'belleza'],
    ['nombre' => 'Mascotas sec', 'descripcion' => 'Productos para animales domésticos', 'slug' => 'mascotas'],
    ['nombre' => 'Libros sec', 'descripcion' => 'Literatura y material educativo', 'slug' => 'libros'],
    ['nombre' => 'Música sec', 'descripcion' => 'Instrumentos y accesorios musicales', 'slug' => 'musica'],
    ['nombre' => 'Salud sec', 'descripcion' => 'Productos de bienestar y salud', 'slug' => 'salud'],
    ['nombre' => 'Videojuegos sec', 'descripcion' => 'Consolas y juegos digitales', 'slug' => 'videojuegos'],
    ['nombre' => 'Panadería sec', 'descripcion' => 'Productos de pan y repostería', 'slug' => 'panaderia'],
    ['nombre' => 'Verduras sec', 'descripcion' => 'Hortalizas frescas', 'slug' => 'verduras'],
    ['nombre' => 'Accesorios sec', 'descripcion' => 'Complementos de moda y estilo', 'slug' => 'accesorios'],
]);
    }
}

