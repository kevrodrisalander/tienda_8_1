<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'detalle_cliente',
        'detalle_administrativo',
        'observaciones',
        'stock',
        'precio_venta',
        'id_status',
        'id_categoria',
        'id_marca',
        'fecha',
        'name_file',
        'stock_actual',
    ];

    // Relación con Stock
    public function stock()
    {
        return $this->hasMany(Stock::class, 'producto_id');
    }

    public function getStockActualAttribute()
    {
        $total = DB::table('stock')
            ->where('producto_id', $this->id)
            ->sum(DB::raw("
            CASE
                WHEN tipo_movimiento IN ('entrada','ajuste') THEN cantidad
                WHEN tipo_movimiento = 'salida' THEN -cantidad
                ELSE 0
            END
        "));

        return $total;
    }
}
