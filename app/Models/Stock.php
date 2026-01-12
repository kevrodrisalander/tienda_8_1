<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto; // Importar la clase Producto

class Stock extends Model
{
    protected $table = 'stock';

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
        'usuario_id',
        'activo',
        'fecha_salida', // <--- importante
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
