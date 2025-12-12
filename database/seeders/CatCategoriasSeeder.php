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
        ]);
    }
}
