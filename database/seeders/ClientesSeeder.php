<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    public function run(): void
    {
        // 🛡️ Limpieza segura previniendo bloqueos por FK
        DB::statement('TRUNCATE TABLE clientes CASCADE;');

        // Inserción masiva usando el mapeo de columnas original
        DB::table('clientes')->insert([
            [
                'id_cliente' => 8,
                'nombre' => 'cliente3',
                'correo' => 'cliente3@gmail.com',
                'telefono' => null,
                'direccion' => null,
                'fecha_registro' => '2026-03-16 12:14:44', // ✅ Cambiado a fecha_registro
                'id_usuario' => 10,                        // ✅ Cambiado a id_usuario
                'activo' => true
            ],
            [
                'id_cliente' => 9,
                'nombre' => 'kevincliente',
                'correo' => 'kevincliente@gmail.com',
                'telefono' => null,
                'direccion' => null,
                'fecha_registro' => '2026-04-16 13:35:47',
                'id_usuario' => 11,
                'activo' => true
            ],
            [
                'id_cliente' => 10,
                'nombre' => 'Joepred',
                'correo' => 'joepred@gmail.com',
                'telefono' => null,
                'direccion' => null,
                'fecha_registro' => '2026-06-02 21:37:39',
                'id_usuario' => 12,
                'activo' => true
            ],
            [
                'id_cliente' => 11,
                'nombre' => 'Yeyon',
                'correo' => 'llelloxdxd@gmail.com',
                'telefono' => null,
                'direccion' => null,
                'fecha_registro' => '2026-06-02 21:41:14',
                'id_usuario' => 13,
                'activo' => true
            ],
            [
                'id_cliente' => 12,
                'nombre' => 'Charly',
                'correo' => 'charly@mail.com',
                'telefono' => null,
                'direccion' => null,
                'fecha_registro' => '2026-06-07 15:02:22',
                'id_usuario' => 14,
                'activo' => true
            ],
        ]);

        // 🔄 Resincronizar secuencia en Postgres para evitar choques en ID 13+
        DB::statement("SELECT setval(pg_get_serial_sequence('clientes', 'id_cliente'), coalesce(max(id_cliente), 1), max(id_cliente) IS NOT null) FROM clientes;");
    }
}
