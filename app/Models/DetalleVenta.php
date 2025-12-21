<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Modelo DetalleVenta
|--------------------------------------------------------------------------
| Representa el detalle de cada producto incluido en una venta.
| Cada registro corresponde a una línea del ticket o factura.
|
| Campos principales:
| - id_venta        → Referencia a la venta principal (ventas).
| - id_producto     → Producto vendido.
| - cantidad        → Cantidad de unidades vendidas.
| - precio_unitario → Precio del producto al momento de la venta.
| - descuento       → Descuento aplicado a la línea (si aplica).
| - desc_venta      → Descripción adicional o nota de la venta.
|
| NOTA:
| Este modelo NO afecta directamente el stock.
| La salida de inventario se registra mediante la tabla stock,
| la cual funciona como kardex de movimientos.
*/

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
    public $timestamps = true;

    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad',
        'precio_unitario',
        'descuento',
        'desc_venta'
    ];
}
