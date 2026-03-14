<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTipoProductoSeeder extends Seeder
{
    public function run()
    {
        // Elimina todos los registros de la tabla y reinicia el contador de auto-incremento
        DB::table('cat_tipo_producto')->truncate();

        // Ahora puedes insertar los nuevos registros
        DB::table('cat_tipo_producto')->insert([
    ['nombre' => 'Alimento', 'descripcion' => 'Productos comestibles'],
    ['nombre' => 'Ropa', 'descripcion' => 'Vestimenta y accesorios'],
    ['nombre' => 'Hogar', 'descripcion' => 'Artículos para el hogar'],

    // 10 adicionales
    ['nombre' => 'Electrónica', 'descripcion' => 'Dispositivos y gadgets tecnológicos'],
    ['nombre' => 'Juguetes', 'descripcion' => 'Entretenimiento infantil'],
    ['nombre' => 'Deportes', 'descripcion' => 'Equipamiento y accesorios deportivos'],
    ['nombre' => 'Oficina', 'descripcion' => 'Papelería y suministros de oficina'],
    ['nombre' => 'Belleza', 'descripcion' => 'Cosméticos y productos de cuidado personal'],
    ['nombre' => 'Mascotas', 'descripcion' => 'Alimentos y accesorios para animales'],
    ['nombre' => 'Libros', 'descripcion' => 'Literatura y material educativo'],
    ['nombre' => 'Música', 'descripcion' => 'Instrumentos y accesorios musicales'],
    ['nombre' => 'Videojuegos', 'descripcion' => 'Consolas y juegos digitales'],
    ['nombre' => 'Salud', 'descripcion' => 'Productos de bienestar y cuidado médico'],
]);
    }
}


