<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTipoAlmacenSeeder extends Seeder
{
    public function run()
    {
        // Elimina todos los registros de la tabla y reinicia el contador de auto-incremento
        DB::table('cat_tipo_almacen')->truncate();

        // Inserta los nuevos registros
        DB::table('cat_tipo_almacen')->insert([
            ['nombre' => 'Almacén General', 'descripcion' => 'Almacén principal para todo tipo de productos'],
            ['nombre' => 'Almacén de Materia Prima', 'descripcion' => 'Recepción y resguardo de insumos'],
            ['nombre' => 'Almacén de Producto Terminado', 'descripcion' => 'Productos listos para distribución'],
            ['nombre' => 'Almacén de Seguridad', 'descripcion' => 'Materiales peligrosos o controlados'],
            ['nombre' => 'Almacén de Repuestos', 'descripcion' => 'Piezas y componentes para mantenimiento'],
            ['nombre' => 'Almacén Temporal', 'descripcion' => 'Almacenaje provisional por alta rotación'],
            ['nombre' => 'Almacén Fiscal', 'descripcion' => 'Almacén bajo régimen aduanal'],
            ['nombre' => 'Almacén de Devoluciones', 'descripcion' => 'Productos devueltos por clientes'],
            ['nombre' => 'Almacén de Frío', 'descripcion' => 'Productos que requieren refrigeración'],
            ['nombre' => 'Almacén de Alta Rotación', 'descripcion' => 'Productos con salida frecuente'],
        ]);
    }
}
