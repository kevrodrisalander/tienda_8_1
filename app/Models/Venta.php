<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'total',
        'id_cliente',
        'metodo_pago',
        'id_estatus'
    ];

    /**
     * Relación con los detalles de la venta
     */
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
    }

    /**
     * Relación cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function envio()
{
    return $this->hasOne(Envio::class, 'id_pedido', 'id_venta');
}
}
