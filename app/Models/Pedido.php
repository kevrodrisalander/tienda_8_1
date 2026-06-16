<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
protected $table = 'pedidos';
protected $primaryKey = 'id_pedido';
public $timestamps = false;

public function envio()
{
return $this->hasOne(Envio::class, 'id_pedido');
}
}
