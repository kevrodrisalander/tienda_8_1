<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTipoAlmacenSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_tipo_almacen')->insert([
            ['id_tipo_almacen' => 1, 'nombre' => 'Almacén General', 'descripcion' => 'Almacén principal para todo tipo de productos'],
            ['id_tipo_almacen' => 2, 'nombre' => 'Almacén de Materia Prima', 'descripcion' => 'Recepción y resguardo de insumos'],
            ['id_tipo_almacen' => 3, 'nombre' => 'Almacén de Producto Terminado', 'descripcion' => 'Productos listos para distribución'],
            ['id_tipo_almacen' => 4, 'nombre' => 'Almacén de Seguridad', 'descripcion' => 'Materiales peligrosos o controlados'],
            ['id_tipo_almacen' => 5, 'nombre' => 'Almacén de Repuestos', 'descripcion' => 'Piezas y componentes para mantenimiento'],
            ['id_tipo_almacen' => 6, 'nombre' => 'Almacén Temporal', 'descripcion' => 'Almacenaje provisional por alta rotación'],
            ['id_tipo_almacen' => 7, 'nombre' => 'Almacén Fiscal', 'descripcion' => 'Almacén bajo régimen aduanal'],
            ['id_tipo_almacen' => 8, 'nombre' => 'Almacén de Devoluciones', 'descripcion' => 'Productos devueltos por clientes'],
            ['id_tipo_almacen' => 9, 'nombre' => 'Almacén de Frío', 'descripcion' => 'Productos que requieren refrigeración'],
            ['id_tipo_almacen' => 10, 'nombre' => 'Almacén de Alta Rotación', 'descripcion' => 'Productos con salida frecuente'],
        ]);
    }
}
