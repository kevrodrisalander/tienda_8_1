<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto; // Importar la clase Producto

class Stock extends Model
{
    protected $table = 'stock'; // <- nombre real de tu tabla
    public $timestamps = false; // si tu tabla no tiene created_at / updated_at

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
    ];

    // Relación inversa con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
