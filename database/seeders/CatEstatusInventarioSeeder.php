<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatEstatusInventarioSeeder extends Seeder
{
   public function run()
{
    // Elimina todos los registros y reinicia el contador del auto-incremento
    DB::table('cat_estatus_inventario')->truncate();

    // Ahora puedes insertar los nuevos registros sin conflictos
    DB::table('cat_estatus_inventario')->insert([
    ['activo' => 1, 'created_at' => now(), 'deleted_at' => null, 'modified_at' => now(), 'tipo' => 'Disponible'],
    ['activo' => 1, 'created_at' => now(), 'deleted_at' => null, 'modified_at' => now(), 'tipo' => 'Apartado x'],
    ['activo' => 1, 'created_at' => now(), 'deleted_at' => null, 'modified_at' => now(), 'tipo' => 'Agotado'],
    ['activo' => 1, 'created_at' => now(), 'deleted_at' => null, 'modified_at' => now(), 'tipo' => 'En tránsito'],
    ['activo' => 1, 'created_at' => now(), 'deleted_at' => null, 'modified_at' => now(), 'tipo' => 'En revisión'],
    ['activo' => 1, 'created_at' => now(), 'deleted_at' => null, 'modified_at' => now(), 'tipo' => 'Devuelto'],
    ['activo' => 1, 'created_at' => now(), 'deleted_at' => null, 'modified_at' => now(), 'tipo' => 'Reservado'],
    ['activo' => 1, 'created_at' => now(), 'deleted_at' => null, 'modified_at' => now(), 'tipo' => 'Dañado'],
]);
}

}
