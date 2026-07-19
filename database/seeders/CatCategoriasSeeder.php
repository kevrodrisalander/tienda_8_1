<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatCategoriasSeeder extends Seeder
{
    public function run()
    {
        // Limpieza segura en Postgres evitando bloqueos por FK
        DB::statement('TRUNCATE TABLE cat_categorias CASCADE;');

        // Inserción forzando tus IDs originales exactos
        DB::table('cat_categorias')->insert([
            ['id' => 1, 'categoria' => 'Electronica', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 2, 'categoria' => 'Ropa', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 3, 'categoria' => 'Hogar', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 4, 'categoria' => 'Juguetes', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 5, 'categoria' => 'Deportes', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 6, 'categoria' => 'Oficina', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 7, 'categoria' => 'Frutas', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 8, 'categoria' => 'Automotriz', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 9, 'categoria' => 'Belleza', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 10, 'categoria' => 'Mascotas', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 11, 'categoria' => 'Libros', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 12, 'categoria' => 'Música', 'fecha' => '2026-03-16 11:14:31'], // 🌟 Colocado en su lugar correcto
            ['id' => 13, 'categoria' => 'Salud', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 14, 'categoria' => 'Videojuegos', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 15, 'categoria' => 'Panadería', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 16, 'categoria' => 'Verduras', 'fecha' => '2026-03-16 11:14:31'],
            ['id' => 17, 'categoria' => 'Accesorios', 'fecha' => '2026-03-16 11:14:31'],
        ]);

        //  Resincronizamos la secuencia de Postgres para que empiece desde el ID 18 en adelante
        DB::statement("SELECT setval(pg_get_serial_sequence('cat_categorias', 'id'), coalesce(max(id), 1), max(id) IS NOT null) FROM cat_categorias;");
    }
}