<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Vaciar la tabla antes de insertar
        DB::table('permisos')->truncate();

        // Insertar los registros
        DB::table('permisos')->insert([
            ['id' => 1, 'rol' => 'Administrador'],
            ['id' => 2, 'rol' => 'Usuario'],
        ]);
    }
}
