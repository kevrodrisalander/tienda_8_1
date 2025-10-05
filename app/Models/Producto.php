<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Nombre real de la tabla
    protected $table = 'productos';

    // Llave primaria
    protected $primaryKey = 'id';

    // Tu tabla NO tiene created_at / updated_at
    public $timestamps = false;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'descripcion',
        'stock',
        'precio_venta',
        'id_status',
        'id_categoria',
        'name_file',
        'fecha',
    ];
}
