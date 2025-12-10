<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'stock',
        'precio_venta',
        'id_status',
        'id_categoria',
        'id_marca',
        'name_file',
        'fecha',
    ];

    // Relación con Stock
    public function stock()
    {
        return $this->hasMany(Stock::class, 'producto_id');
    }
}
