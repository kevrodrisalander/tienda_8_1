<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatMetodosPagoSeeder extends Seeder
{
    public function run()
{
    // Elimina todos los registros de la tabla y reinicia el contador de auto-incremento
    DB::table('cat_metodos_pago')->truncate();

    // Ahora puedes insertar los nuevos registros
    DB::table('cat_metodos_pago')->insert([
        ['descripcion' => 'Pago realizado en moneda física', 'nombre' => 'Efectivo'],
        ['descripcion' => 'Pago con tarjeta bancaria de crédito', 'nombre' => 'Tarjeta de crédito'],
        ['descripcion' => 'Pago con tarjeta bancaria de débito', 'nombre' => 'Tarjeta de débito'],
        ['descripcion' => 'Pago mediante transferencia electrónica', 'nombre' => 'Transferencia bancaria'],
        ['descripcion' => 'Pago a través de la plataforma PayPal', 'nombre' => 'PayPal'],
        ['descripcion' => 'Pago usando la plataforma Mercado Pago', 'nombre' => 'Mercado Pago'],
        ['descripcion' => 'Pago mediante cheque bancario', 'nombre' => 'Cheque'],
        ['descripcion' => 'Pago con vales físicos o electrónicos', 'nombre' => 'Vales'],
        ['descripcion' => 'Pago a crédito ofrecido por la empresa', 'nombre' => 'Crédito interno'],
        ['descripcion' => 'Pago con monedas digitales como Bitcoin o Ethereum', 'nombre' => 'Criptomoneda'],
    ]);
}

}
