<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $cantidad = $request->input('cantidad', 1);

        // Carrito en sesión
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['cantidad'] += $cantidad;
        } else {
            $cart[$id] = [
                'nombre' => $producto->descripcion,
                'precio' => $producto->precio_venta,
                'cantidad' => $cantidad,
                'imagen' => $producto->name_file,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Producto añadido al carrito');
    }
}
