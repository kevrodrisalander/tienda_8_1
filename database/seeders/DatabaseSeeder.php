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
        // 🔹 1. Catálogos e Infraestructura Base (Tablas maestras sin dependencias externas)
        $this->call([
            CatCategoriasSeeder::class,
            CatEStatusInventarioSeeder::class,
            CatProvedoresSeeder::class, // Valida que tu archivo mantenga esta ortografía con una sola 'e'
            ProveedoresSeeder::class,
            CatMarcasSeeder::class,
            CatMetodosPagoSeeder::class,
            CatRolesSeeder::class,
            CatSeccionesSeeder::class,
            CatTipoAlmacenSeeder::class,
            CatTipoMovimientoSeeder::class,
            CatTipoProductoSeeder::class,
            CatUbicacionDeptoSeeder::class,
        ]);

        // 🔹 2. Entidades Principales e Inventario (Dependen estrictamente del bloque 1)
        $this->call([
            ProductosSeeder::class,      // Crea los productos base (ej. Cereza)
            LotesProductoSeeder::class,  // Asigna lotes a los productos existentes
            CatUbicacionesSeeder::class, // Espacios físicos del almacén
        ]);

        // 🔹 3. Personal, Seguridad Administrativa y Clientes
        $this->call([
            UsuariosSeeder::class,       // Primero creamos los usuarios para que existan en el sistema
            PermisosSeeder::class,       // Asignamos los permisos correspondientes a esos IDs de usuario
            ClientesSeeder::class,

            // 💡 NOTA: Si tienes un 'ClientesSeeder' para poblar los datos de prueba de quienes compran,
            // agrégalo justo aquí abajo de UsuariosSeeder para asegurar que los IDs (como el 9) existan.
        ]);

        // 🔹 4. Ventas y Operaciones Comerciales
        // Los pedidos necesitan que existan Clientes/Usuarios previamente en el bloque 3.
        $this->call([
            // PedidosSeeder::class,     // Descomenta esta línea si creas un seeder para tus pedidos iniciales
        ]);

        // 🔹 5. Transacciones y Movimientos Históricos (Kardex Puro)
        // Se ejecuta al último porque los ajustes y salidas de stock dependen de Productos, Usuarios y Ventas
        $this->call([
            StockSeeder::class,          // Inserta las entradas iniciales limpias vinculadas a productos y usuarios
        ]);
    }
}
