<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpieza segura
        DB::statement('TRUNCATE TABLE usuarios CASCADE;');

        DB::table('usuarios')->insert([
            // Tus usuarios administrativos previos (ej. admin id 1, etc.) si es que tenías
            [
                'id' => 1,
                'usuario' => 'admin',
                'correo' => 'admin@cherry.com',
                'clave' => Hash::make('123456'),
                'id_rol' => 1,
                'fecha' => '2026-03-16 11:14:31'
            ],

            // 🌟 FORZAR LOS IDS DEL 10 AL 14 PARA TUS CLIENTES
            [
                'id' => 10,
                'usuario' => 'user_cliente3',
                'correo' => 'cliente3@gmail.com',
                'clave' => Hash::make('password_seguro'),
                'id_rol' => 2,
                'fecha' => '2026-03-16 12:14:44'
            ],
            [
                'id' => 11,
                'usuario' => 'user_kevin',
                'correo' => 'kevincliente@gmail.com',
                'clave' => Hash::make('password_seguro'),
                'id_rol' => 2,
                'fecha' => '2026-04-16 13:35:47'
            ],
            [
                'id' => 12,
                'usuario' => 'user_joepred',
                'correo' => 'joepred@gmail.com',
                'clave' => Hash::make('password_seguro'),
                'id_rol' => 2,
                'fecha' => '2026-06-02 21:37:39'
            ],
            [
                'id' => 13,
                'usuario' => 'user_yeyon',
                'correo' => 'llelloxdxd@gmail.com',
                'clave' => Hash::make('password_seguro'),
                'id_rol' => 2,
                'fecha' => '2026-06-02 21:41:14'
            ],
            [
                'id' => 14, // 🌟 ¡Este es el que te pedía a gritos el error!
                'usuario' => 'user_charly',
                'correo' => 'charly@mail.com',
                'clave' => Hash::make('password_seguro'),
                'id_rol' => 2,
                'fecha' => '2026-06-07 15:02:22'
            ],
        ]);

        // 🔄 Resincronizar la secuencia de la tabla usuarios en Postgres
        DB::statement("SELECT setval(pg_get_serial_sequence('usuarios', 'id'), coalesce(max(id), 1), max(id) IS NOT null) FROM usuarios;");
    }
}