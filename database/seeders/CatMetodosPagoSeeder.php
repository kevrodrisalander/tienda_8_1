<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatMetodosPagoSeeder extends Seeder
{
    public function run()
    {
        DB::table('cat_metodos_pago')->insert([
            ['id_metodo' => 1, 'nombre' => 'Efectivo', 'descripcion' => 'Pago realizado en moneda física'],
            ['id_metodo' => 2, 'nombre' => 'Tarjeta de crédito', 'descripcion' => 'Pago con tarjeta bancaria de crédito'],
            ['id_metodo' => 3, 'nombre' => 'Tarjeta de débito', 'descripcion' => 'Pago con tarjeta bancaria de débito'],
            ['id_metodo' => 4, 'nombre' => 'Transferencia bancaria', 'descripcion' => 'Pago mediante transferencia electrónica'],
            ['id_metodo' => 5, 'nombre' => 'PayPal', 'descripcion' => 'Pago a través de la plataforma PayPal'],
            ['id_metodo' => 6, 'nombre' => 'Mercado Pago', 'descripcion' => 'Pago usando la plataforma Mercado Pago'],
            ['id_metodo' => 7, 'nombre' => 'Cheque', 'descripcion' => 'Pago mediante cheque bancario'],
            ['id_metodo' => 8, 'nombre' => 'Vales', 'descripcion' => 'Pago con vales físicos o electrónicos'],
            ['id_metodo' => 9, 'nombre' => 'Crédito interno', 'descripcion' => 'Pago a crédito ofrecido por la empresa'],
            ['id_metodo' => 10, 'nombre' => 'Criptomoneda', 'descripcion' => 'Pago con monedas digitales como Bitcoin o Ethereum'],
        ]);
    }
}
