<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    // IMPORTANTE: Permitir que Laravel inserte estos campos
    protected $fillable = [
        'id_cliente',
        'fecha_pedido',
        'estado'
    ];

    public function envio()
    {
        return $this->hasOne(Envio::class, 'id_pedido');
    }

    public function cliente()
    {
        // Cambia 'id_cliente' si tu columna de clave foránea en la tabla pedidos se llama diferente
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }
}
