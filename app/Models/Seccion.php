<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $table = 'cat_secciones';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'descripcion_larga',   // 👈 NUEVO
        'precio_venta',
        'cantidad_stock',
        'name_file',
        'seccion_id'
    ];
}
