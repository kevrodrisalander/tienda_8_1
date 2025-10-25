<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
   protected $fillable = [
    'producto_id',
    'cantidad',
    'minimo_seguro',
    'maximo_permitido',
    'ubicacion',
    'estado',
    'id_lote',
    'tipo_movimiento',
    'fecha_ingreso',
    'fecha_vencimiento',
    'observaciones',
    // 'actualizado_en',
];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
