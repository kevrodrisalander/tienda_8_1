<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use PDF;

class CartController extends Controller
{
    // Agregar producto al carrito
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

    // Vaciar carrito
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Carrito vaciado');
    }

    // Mostrar carrito
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.test', compact('cart'));
    }
public function checkout(Request $request)
{
    $cart = $request->cart; // ya es un array, perfecto

    $pdf = \PDF::loadView('pdf.ticket', compact('cart'))
            ->setPaper('a4')
            ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isRemoteEnabled' => true
            ]);

    // Limpia cualquier contenido previo en el buffer para que el PDF no se corrompa
    if (ob_get_length()) {
        ob_end_clean();
    }

    return $pdf->download('ticket.pdf');
}


}
