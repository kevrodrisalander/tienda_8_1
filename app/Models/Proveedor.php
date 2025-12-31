<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Modelo para la tabla de proveedores
class Proveedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proveedores'; // nombre de tu tabla
    protected $fillable = [
        'nombre_proveedor',
        'contacto',
        'telefono',
        'email',
        'direccion',
        'id_cat_marcas'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }
}


