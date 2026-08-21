<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Pago confirmado de un pedido.
 *
 * Esta entidad no almacena información sensible de la tarjeta. Solamente se
 * conservan datos operativos útiles para el ticket y la conciliación.
 */
class PagoPedido extends Model
{
    protected $table = 'pagos_pedido';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_pedido',
        'metodo',
        'monto',
        'monto_recibido',
        'cambio',
        'tipo_tarjeta',
        'marca_tarjeta',
        'ultimos_cuatro',
        'emisor_vale',
        'referencia',
        'fecha_pago',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'monto_recibido' => 'decimal:2',
        'cambio' => 'decimal:2',
        'fecha_pago' => 'datetime',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    public function getNombreMetodoAttribute(): string
    {
        return match ($this->metodo) {
            'tarjeta' => $this->tipo_tarjeta === 'credito'
                ? 'Tarjeta de crédito'
                : 'Tarjeta de débito',
            'vales' => 'Vales de despensa',
            default => 'Efectivo',
        };
    }
}
