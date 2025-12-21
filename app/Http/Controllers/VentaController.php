<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Stock;

class VentaController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = $request->cart;

        if (!$cart || count($cart) === 0) {
            return response()->json(['error' => 'Carrito vacío'], 400);
        }

        DB::beginTransaction();

        try {
            // 🔹 calcular total REAL
            $total = collect($cart)->sum(function ($item) {
                return $item['precio'] * $item['cantidad'];
            });

            // 🔹 crear venta
            $venta = Venta::create([
                'fecha'       => now(),
                'total'       => $total,
                'id_cliente'  => 1,
                'metodo_pago' => 'EFECTIVO',
                'id_estatus'  => 1,
            ]);

            /*
|--------------------------------------------------------------------------
| Registro del detalle de venta y salida de inventario
|--------------------------------------------------------------------------
| Por cada producto incluido en el carrito:
|
| 1) Se registra el detalle de la venta en la tabla detalle_venta,
|    asociando el producto, la cantidad vendida y el precio unitario.
|
| 2) Se registra un movimiento de salida en la tabla stock.
|    - La cantidad se guarda como valor NEGATIVO para reflejar egreso.
|    - Se utiliza abs() para asegurar que la salida siempre reste stock.
|    - El tipo de movimiento 195 corresponde a "Salida por venta".
|
| El stock real del producto se obtiene posteriormente sumando todos
| los movimientos registrados en la tabla stock (kardex).
*/
            // 🔹 detalle + salida de stock
            foreach ($cart as $item) {

                DetalleVenta::create([
                    'id_venta'        => $venta->id_venta,
                    'id_producto'     => $item['id'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);
                Stock::create([
                    'producto_id'        => $item['id'],
                    'cantidad'           => -abs($item['cantidad']), // salida SIEMPRE negativa
                    'tipo_movimiento_id' => 195, // Salida por venta
                    'estado'             => 'CONFIRMADO',
                ]);
            }

            DB::commit();

            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
