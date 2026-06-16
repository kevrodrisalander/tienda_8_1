<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table = 'envios';
    protected $primaryKey = 'id_envio';
    public $timestamps = false;

    // ✅ Campos permitidos para asignación masiva
    protected $fillable = [
        'id_pedido',
        'direccion',
        'telefono',
        'referencias',
        'estado_envio',
        'fecha_envio',
        'transportista',
        'numero_guia'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}