<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'id' => 1,
                'usuario' => 'Administrador',
                'correo' => 'admin@gmail.com',
                'clave' => '$2y$12$jsGFxU4KCunDLEYTjKip5ejWmzeMha6nhyZVrU7K48firHHX.oCbm',
                'id_rol' => 1,
                'fecha' => '2024-05-12 16:19:12'
            ],
            [
                'id' => 2,
                'usuario' => 'Example',
                'correo' => 'example@gmail.com',
                'clave' => '$2y$12$jsGFxU4KCunDLEYTjKip5ejWmzeMha6nhyZVrU7K48firHHX.oCbm',
                'id_rol' => 2,
                'fecha' => '2024-05-12 16:19:21'
            ],
            [
                'id' => 3,
                'usuario' => 'Emanuel',
                'correo' => 'example@gmail.com.mx',
                'clave' => '$2y$12$jsGFxU4KCunDLEYTjKip5ejWmzeMha6nhyZVrU7K48firHHX.oCbm',
                'id_rol' => 2,
                'fecha' => '2024-05-12 16:23:08'
            ],
            [
                'id' => 4,
                'usuario' => 'Alejandro',
                'correo' => 'newuser@genotipo.com',
                'clave' => '$2y$12$jsGFxU4KCunDLEYTjKip5ejWmzeMha6nhyZVrU7K48firHHX.oCbm',
                'id_rol' => 2,
                'fecha' => '2024-05-12 23:53:00'
            ],
            [
                'id' => 5,
                'usuario' => 'Alex',
                'correo' => 'lex@hotmail.com',
                'clave' => '$2y$12$jsGFxU4KCunDLEYTjKip5ejWmzeMha6nhyZVrU7K48firHHX.oCbm',
                'id_rol' => 2,
                'fecha' => '2024-05-13 14:39:24'
            ],
            [
                'id' => 6,
                'usuario' => 'Marcos',
                'correo' => 'marcos@gmail.com',
                'clave' => '$2y$12$jsGFxU4KCunDLEYTjKip5ejWmzeMha6nhyZVrU7K48firHHX.oCbm',
                'id_rol' => 2,
                'fecha' => '2024-09-07 17:40:50'
            ],
            [
                'id' => 7,
                'usuario' => 'kevin.dos',
                'correo' => 'kev@gmail.com',
                'clave' => '$2y$12$jsGFxU4KCunDLEYTjKip5ejWmzeMha6nhyZVrU7K48firHHX.oCbm',
                'id_rol' => 6,
                'fecha' => '2025-11-24 13:32:00.391'
            ],
            [
                'id' => 8,
                'usuario' => 'karla',
                'correo' => 'karla.lozano@gmail.com',
                'clave' => '$2y$12$jsGFxU4KCunDLEYTjKip5ejWmzeMha6nhyZVrU7K48firHHX.oCbm',
                'id_rol' => 6,
                'fecha' => '2025-12-06 13:23:30.947'
            ],
        ]);
    }
}
