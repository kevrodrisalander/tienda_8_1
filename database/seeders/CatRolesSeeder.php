<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatRolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_roles')->insert([
            ['id_rol' => 1, 'nombre' => 'Administrador', 'descripcion' => 'Acceso total al sistema, incluyendo configuración y gestión de usuarios'],
            ['id_rol' => 2, 'nombre' => 'Supervisor', 'descripcion' => 'Supervisa operaciones y reportes, con acceso limitado a configuración'],
            ['id_rol' => 3, 'nombre' => 'Vendedor', 'descripcion' => 'Realiza ventas y gestiona clientes'],
            ['id_rol' => 4, 'nombre' => 'Almacén', 'descripcion' => 'Gestiona inventario y movimientos de productos'],
            ['id_rol' => 5, 'nombre' => 'Contador', 'descripcion' => 'Accede a reportes financieros y contables'],
            ['id_rol' => 6, 'nombre' => 'Cliente', 'descripcion' => 'Usuario externo con acceso a su historial y pedidos'],
            ['id_rol' => 7, 'nombre' => 'Soporte técnico', 'descripcion' => 'Atiende incidencias y da mantenimiento al sistema'],
            ['id_rol' => 8, 'nombre' => 'Compras', 'descripcion' => 'Gestiona órdenes de compra y proveedores'],
            ['id_rol' => 9, 'nombre' => 'Recursos Humanos', 'descripcion' => 'Administra personal, roles y permisos'],
            ['id_rol' => 10, 'nombre' => 'Invitado', 'descripcion' => 'Acceso limitado para revisión o demostración'],
        ]);
    }
}
