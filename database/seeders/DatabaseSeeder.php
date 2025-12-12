<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero, inserta las categorías, marcas, métodos de pago, etc.
        $this->call([
            CatCategoriasSeeder::class,
            CatEStatusInventarioSeeder::class,
            CatProvedoresSeeder::class,
            CatMarcasSeeder::class,
            CatMetodosPagoSeeder::class,
            CatRolesSeeder::class,
            CatSeccionesSeeder::class,
            CatTipoAlmacenSeeder::class,
            CatTipoMovimientoSeeder::class,
            CatTipoProductoSeeder::class,
            CatUbicacionDeptoSeeder::class,
        ]);

        // Luego, inserta productos y datos relacionados.
        $this->call([
            ProductosSeeder::class,
            LotesProductoSeeder::class,
            CatUbicacionesSeeder::class,
            StockSeeder::class,
        ]);

        // Finalmente, inserta usuarios y permisos.
        $this->call([
            PermisosSeeder::class,
            UsuariosSeeder::class,
        ]);
    }
}
