<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Modelo DetalleVenta
|--------------------------------------------------------------------------
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

    /**
     * Relación con Producto
     * Necesaria para generar el PDF del ticket
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
