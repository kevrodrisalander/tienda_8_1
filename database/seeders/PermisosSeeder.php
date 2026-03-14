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

    // 10 adicionales
    ['id' => 3, 'rol' => 'Editor'],
    ['id' => 4, 'rol' => 'Moderador'],
    ['id' => 5, 'rol' => 'Invitado'],
    ['id' => 6, 'rol' => 'Supervisor'],
    ['id' => 7, 'rol' => 'Gerente'],
    ['id' => 8, 'rol' => 'Colaborador'],
    ['id' => 9, 'rol' => 'Soporte'],
    ['id' => 10, 'rol' => 'Analista'],
    ['id' => 11, 'rol' => 'Auditor'],
    ['id' => 12, 'rol' => 'Root'],
]);
    }
}
