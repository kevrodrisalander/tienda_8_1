<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Tu sesión ha expirado. Inicia sesión de nuevo.'], 401);
        }

        $validated = $request->validate([
            'cart' => ['required', 'array', 'min:1'],
            'cart.*.id' => ['required', 'integer', 'exists:productos,id'],
            'cart.*.cantidad' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $pedido = DB::transaction(function () use ($validated) {
                $clienteId = optional(Auth::user()->cliente)->id_cliente ?? Auth::id();
                $pedido = Pedido::create([
                    'id_cliente' => $clienteId,
                    'fecha_pedido' => now(),
                    'estado' => 'pendiente',
                ]);

                foreach ($validated['cart'] as $item) {
                    $producto = Producto::query()->lockForUpdate()->findOrFail($item['id']);
                    $cantidad = (int) $item['cantidad'];
                    $existencia = max(0, (int) $producto->stock);

                    if ($cantidad > $existencia) {
                        throw ValidationException::withMessages([
                            'cart' => "No hay existencia suficiente de {$producto->descripcion}. Disponible: {$existencia}.",
                        ]);
                    }

                    // El nombre y precio se conservan como una fotografía de la compra.
                    DetallePedido::create([
                        'id_pedido' => $pedido->id_pedido,
                        'id_producto' => $producto->id,
                        'nombre_producto' => $producto->descripcion,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $producto->precio_venta,
                    ]);

                    DB::table('stock')->insert([
                        'producto_id' => $producto->id,
                        'cantidad' => $cantidad,
                        'tipo_movimiento' => 'salida',
                        'estado' => 'disponible',
                        'activo' => true,
                        'usuario_id' => Auth::id(),
                        'fecha_salida' => now(),
                        'observaciones' => 'Salida por venta - Pedido #' . $pedido->id_pedido,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $producto->update(['stock' => $existencia - $cantidad]);
                }

                return $pedido;
            });

            return response()->json(['id_pedido' => $pedido->id_pedido]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['error' => 'No fue posible procesar la compra.'], 500);
        }
    }

    public function descargarTicket($id)
    {
        $pedido = Pedido::with(['detalles', 'envio'])->findOrFail($id);

        if ($pedido->detalles->isEmpty()) {
            abort(422, 'Este pedido no contiene productos registrados y no puede generar un ticket válido.');
        }

        $cart = $pedido->detalles->map(fn ($detalle) => [
            'nombre' => $detalle->nombre_producto,
            'cantidad' => (int) $detalle->cantidad,
            'precio' => (float) $detalle->precio_unitario,
        ])->all();

        $pdf = Pdf::loadView('pdf.ticket', [
            'cart' => $cart,
            'pedido' => $pedido,
            'esEnvio' => $pedido->envio !== null,
            'metodo_pago' => 'Efectivo',
        ]);

        // 80 mm de ancho; la altura amplia evita cortar compras con varios artículos.
        $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait');

        return $pdf->stream('ticket-pedido-' . $pedido->id_pedido . '.pdf');
    }
}
