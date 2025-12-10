<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatUbicacionesSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_ubicaciones')->insert([
            ['id_ubicacion' => 1, 'clave_ubicacion' => 'UB001', 'nombre_ubicacion' => 'Bodega Central Norte', 'tipo_ubicacion' => 'Bodega', 'direccion' => 'Av. Reforma 123', 'ciudad' => 'CDMX', 'estado' => 'CDMX', 'codigo_postal' => '06000', 'telefono' => '555-1234', 'capacidad_m2' => 1500, 'estatus' => true],
            ['id_ubicacion' => 2, 'clave_ubicacion' => 'UB002', 'nombre_ubicacion' => 'Almacén Sur', 'tipo_ubicacion' => 'Almacén', 'direccion' => 'Calle 10 #45', 'ciudad' => 'Tlalpan', 'estado' => 'CDMX', 'codigo_postal' => '14000', 'telefono' => '555-5678', 'capacidad_m2' => 800, 'estatus' => true],
            ['id_ubicacion' => 3, 'clave_ubicacion' => 'UB003', 'nombre_ubicacion' => 'Centro Distribución Oriente', 'tipo_ubicacion' => 'Centro de distribución', 'direccion' => 'Av. Tláhuac 789', 'ciudad' => 'Iztapalapa', 'estado' => 'CDMX', 'codigo_postal' => '09700', 'telefono' => '555-9012', 'capacidad_m2' => 2000, 'estatus' => true],
            ['id_ubicacion' => 4, 'clave_ubicacion' => 'UB004', 'nombre_ubicacion' => 'Bodega Querétaro', 'tipo_ubicacion' => 'Bodega', 'direccion' => 'Av. 5 de Febrero 321', 'ciudad' => 'Querétaro', 'estado' => 'Querétaro', 'codigo_postal' => '76000', 'telefono' => '442-1111', 'capacidad_m2' => 1200, 'estatus' => true],
            ['id_ubicacion' => 5, 'clave_ubicacion' => 'UB005', 'nombre_ubicacion' => 'Almacén Guadalajara', 'tipo_ubicacion' => 'Almacén', 'direccion' => 'Av. Vallarta 456', 'ciudad' => 'Guadalajara', 'estado' => 'Jalisco', 'codigo_postal' => '44100', 'telefono' => '333-2222', 'capacidad_m2' => 1000, 'estatus' => true],
            ['id_ubicacion' => 6, 'clave_ubicacion' => 'UB006', 'nombre_ubicacion' => 'Centro Distribución Monterrey', 'tipo_ubicacion' => 'Centro de distribución', 'direccion' => 'Av. Constitución 789', 'ciudad' => 'Monterrey', 'estado' => 'Nuevo León', 'codigo_postal' => '64000', 'telefono' => '818-3333', 'capacidad_m2' => 2500, 'estatus' => true],
            ['id_ubicacion' => 7, 'clave_ubicacion' => 'UB007', 'nombre_ubicacion' => 'Bodega Puebla', 'tipo_ubicacion' => 'Bodega', 'direccion' => 'Blvd. Hermanos Serdán 101', 'ciudad' => 'Puebla', 'estado' => 'Puebla', 'codigo_postal' => '72000', 'telefono' => '222-4444', 'capacidad_m2' => 1100, 'estatus' => true],
            ['id_ubicacion' => 8, 'clave_ubicacion' => 'UB008', 'nombre_ubicacion' => 'Almacén Mérida', 'tipo_ubicacion' => 'Almacén', 'direccion' => 'Calle 60 #123', 'ciudad' => 'Mérida', 'estado' => 'Yucatán', 'codigo_postal' => '97000', 'telefono' => '999-5555', 'capacidad_m2' => 900, 'estatus' => true],
            ['id_ubicacion' => 9, 'clave_ubicacion' => 'UB009', 'nombre_ubicacion' => 'Centro Distribución Toluca', 'tipo_ubicacion' => 'Centro de distribución', 'direccion' => 'Av. Las Torres 456', 'ciudad' => 'Toluca', 'estado' => 'Edo. de México', 'codigo_postal' => '50000', 'telefono' => '722-6666', 'capacidad_m2' => 1800, 'estatus' => true],
            ['id_ubicacion' => 10, 'clave_ubicacion' => 'UB010', 'nombre_ubicacion' => 'Bodega León', 'tipo_ubicacion' => 'Bodega', 'direccion' => 'Blvd. Adolfo López Mateos 789', 'ciudad' => 'León', 'estado' => 'Guanajuato', 'codigo_postal' => '37000', 'telefono' => '477-7777', 'capacidad_m2' => 1300, 'estatus' => true],
        ]);
    }
}
