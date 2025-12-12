<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatRolesSeeder extends Seeder
{
    public function run()
    {
        // Elimina todos los registros de la tabla y reinicia el contador de auto-incremento
        DB::table('cat_roles')->truncate();

        // Ahora puedes insertar los nuevos registros
        DB::table('cat_roles')->insert([
            ['nombre' => 'Administrador', 'descripcion' => 'Acceso total al sistema, incluyendo configuración y gestión de usuarios'],
            ['nombre' => 'Supervisor', 'descripcion' => 'Supervisa operaciones y reportes, con acceso limitado a configuración'],
            ['nombre' => 'Vendedor', 'descripcion' => 'Realiza ventas y gestiona clientes'],
            ['nombre' => 'Almacén', 'descripcion' => 'Gestiona inventario y movimientos de productos'],
            ['nombre' => 'Contador', 'descripcion' => 'Accede a reportes financieros y contables'],
            ['nombre' => 'Cliente', 'descripcion' => 'Usuario externo con acceso a su historial y pedidos'],
            ['nombre' => 'Soporte técnico', 'descripcion' => 'Atiende incidencias y da mantenimiento al sistema'],
            ['nombre' => 'Compras', 'descripcion' => 'Gestiona órdenes de compra y proveedores'],
            ['nombre' => 'Recursos Humanos', 'descripcion' => 'Administra personal, roles y permisos'],
            ['nombre' => 'Invitado', 'descripcion' => 'Acceso limitado para revisión o demostración'],
        ]);
    }
}


