<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatCategoriasSeeder extends Seeder
{
    public function run()
    {
        // Elimina todos los registros de la tabla cat_categorias antes de insertar
        DB::table('cat_categorias')->truncate();

        // Ahora puedes insertar los registros sin problemas
        DB::table('cat_categorias')->insert([
    ['categoria' => 'Electronica', 'fecha' => now()],
    ['categoria' => 'Ropa', 'fecha' => now()],
    ['categoria' => 'Hogar', 'fecha' => now()],
    ['categoria' => 'Juguetes', 'fecha' => now()],
    ['categoria' => 'Deportes', 'fecha' => now()],
    ['categoria' => 'Oficina', 'fecha' => now()],
    ['categoria' => 'Frutas', 'fecha' => now()],
    ['categoria' => 'Automotriz', 'fecha' => now()],
    ['categoria' => 'Belleza', 'fecha' => now()],
    ['categoria' => 'Mascotas', 'fecha' => now()],
    ['categoria' => 'Libros', 'fecha' => now()],
    ['categoria' => 'Música', 'fecha' => now()],
    ['categoria' => 'Salud', 'fecha' => now()],
    ['categoria' => 'Videojuegos', 'fecha' => now()],
    ['categoria' => 'Panadería', 'fecha' => now()],
    ['categoria' => 'Verduras', 'fecha' => now()],
    ['categoria' => 'Accesorios', 'fecha' => now()],
]);
    }
}
