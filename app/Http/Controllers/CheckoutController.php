<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;   // ✅ importación correcta
use App\Models\Envio;

class CheckoutController extends Controller
{
public function checkout(Request $request)
{
    $pedido = Pedido::create([
        'id_cliente' => auth()->id(),
        'fecha_pedido' => now(),
        'estado' => 'pendiente'
    ]);

    return response()->json(['id_pedido' => $pedido->id_pedido]);
}
}
