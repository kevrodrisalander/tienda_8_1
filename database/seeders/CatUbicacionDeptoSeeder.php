<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatUbicacionDeptoSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_ubicacion_depto')->insert([
            ['id' => 1, 'nombre' => 'Recursos Humanos', 'descripcion' => 'Departamento encargado de la gestión del personal', 'pasillo' => '1', 'desc_pasillo' => null],
            ['id' => 2, 'nombre' => 'Finanzas', 'descripcion' => 'Departamento responsable de la contabilidad y presupuesto', 'pasillo' => '2', 'desc_pasillo' => null],
            ['id' => 3, 'nombre' => 'Tecnología', 'descripcion' => 'Área de sistemas y soporte técnico', 'pasillo' => '3', 'desc_pasillo' => null],
            ['id' => 4, 'nombre' => 'Ventas', 'descripcion' => 'Departamento enfocado en la comercialización de productos', 'pasillo' => '4', 'desc_pasillo' => null],
            ['id' => 5, 'nombre' => 'Marketing', 'descripcion' => 'Área encargada de la promoción y publicidad', 'pasillo' => '5', 'desc_pasillo' => null],
            ['id' => 6, 'nombre' => 'Logística', 'descripcion' => 'Departamento que gestiona el transporte y distribución', 'pasillo' => '6', 'desc_pasillo' => null],
            ['id' => 7, 'nombre' => 'Producción', 'descripcion' => 'Área encargada de la fabricación de productos', 'pasillo' => '7', 'desc_pasillo' => null],
            ['id' => 8, 'nombre' => 'Calidad', 'descripcion' => 'Departamento que supervisa los estándares de producción', 'pasillo' => '8', 'desc_pasillo' => null],
            ['id' => 9, 'nombre' => 'Legal', 'descripcion' => 'Área jurídica y de cumplimiento normativo', 'pasillo' => '9', 'desc_pasillo' => null],
            ['id' => 10, 'nombre' => 'Atención al Cliente', 'descripcion' => 'Departamento que brinda soporte a los usuarios', 'pasillo' => '10', 'desc_pasillo' => null],
        ]);
    }
}
