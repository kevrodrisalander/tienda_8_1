<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Envio;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        //1. Validar sesión manualmente para evitar redirecciones del middleware auth
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.'
            ], 401);
        }

        //2. Validar que el carrito llegue en la petición AJAX sin redirigir
        if (!$request->has('cart') || empty($request->cart)) {
            return response()->json([
                'error' => 'El carrito está vacío o no se recibieron los productos.'
            ], 400);
        }

        try {
            //3. Creamos el pedido básico con el cliente logueado
            $pedido = Pedido::create([
                'id_cliente'   => Auth::id(),
                'fecha_pedido' => now(),
                'estado'       => 'pendiente'
            ]);

            //Aseguramos capturar la clave primaria correcta de tu modelo Pedido
            $idFinal = $pedido->id_pedido ?? $pedido->id ?? null;

            if (!$idFinal) {
                return response()->json([
                    'error' => 'El pedido se creó pero no se pudo recuperar su ID. Revisa el $primaryKey en tu Modelo Pedido.'
                ], 500);
            }

            // =================================================================
            // 📦 LÓGICA DE DESCUENTO MEDIANTE EXPRESIONES SQL DIRECTAS E INFALIBLES
            // =================================================================
            $carritoData = $request->cart;

            if (is_string($carritoData)) {
                $carritoData = json_decode($carritoData, true);
            }

            \Log::info('📥 [Checkout] Contenido recibido en el carrito:', ['cart' => $carritoData]);

            if (is_array($carritoData) || $carritoData instanceof \Countable) {
                foreach ($carritoData as $details) {
                    $id_real = $details['id'] ?? null;

                    // Forzamos un entero positivo impecable
                    $cantidadComprada = abs(intval($details['cantidad'] ?? $details['quantity'] ?? 0));

                    if ($id_real && $cantidadComprada > 0) {

                        // 1. Buscamos el registro en la tabla 'stock'
                        $stockItem = \DB::table('stock')
                            ->where('producto_id', $id_real)
                            ->where('activo', 1)
                            ->first();

                        if (!$stockItem) {
                            $stockItem = \DB::table('stock')
                                ->where('id', $id_real)
                                ->where('activo', 1)
                                ->first();
                        }

                        if ($stockItem) {
                            $id_producto_base = $stockItem->producto_id;

                            // 🛠️ RESTA MEDIANTE SQL DIRECTO EN TABLA STOCK
                            \DB::table('stock')
                                ->where('id', $stockItem->id)
                                ->update([
                                    'cantidad' => \DB::raw("GREATEST(0, cantidad - $cantidadComprada)")
                                ]);

                            // Actualizamos el estado si el inventario llegó a 0
                            $checkStockActualizado = \DB::table('stock')->where('id', $stockItem->id)->first();
                            if ($checkStockActualizado && $checkStockActualizado->cantidad <= 0) {
                                \DB::table('stock')->where('id', $stockItem->id)->update(['estado' => 'agotado']);
                            }

                            // 🛠️ RESTA MEDIANTE SQL DIRECTO EN TABLA PRODUCTOS (columna stock)
                            // Usamos GREATEST(0, stock - X) para obligar a Postgres a restar y proteger de negativos
                            \DB::table('productos')
                                ->where('id', $id_producto_base)
                                ->update([
                                    'stock' => \DB::raw("GREATEST(0, stock - $cantidadComprada)")
                                ]);

                            $productoFinalLog = \DB::table('productos')->where('id', $id_producto_base)->first();

                            \Log::info("✅ [Checkout] RESTA DE STOCK CORRECTA. Producto ID {$id_producto_base}. Cantidad comprada: {$cantidadComprada}. Nuevo stock prod: " . ($productoFinalLog->stock ?? 'N/A') . ". Nuevo stock inv: " . ($checkStockActualizado->cantidad ?? 'N/A'));
                        } else {
                            \Log::warning("⚠️ [Checkout] No se encontró en la tabla 'stock' el ID: {$id_real}");
                        }
                    }
                }
            } else {
                \Log::error('❌ [Checkout] El carrito no es un array válido.');
            }
            // =================================================================

            // 4. Retornamos con éxito el ID del pedido en formato JSON limpio
            return response()->json([
                'id_pedido' => $idFinal
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al procesar la compra en la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }

    //Generación del Ticket PDF (DomPDF) estilo Térmico
    public function descargarTicket($id)
    {
        // 1. Buscamos el pedido con los detalles de los productos vendidos
        $pedido = \App\Models\Pedido::find($id);

        if (!$pedido) {
            abort(404, 'El pedido no existe.');
        }

        // 2. Mapeamos los datos para que coincidan exactamente con tu estructura Blade ($cart)
        $cart = [];
        if (isset($pedido->detalles) && count($pedido->detalles) > 0) {
            foreach ($pedido->detalles as $detalle) {
                $cart[] = [
                    'nombre'   => $detalle->producto->nombre ?? 'Producto Genérico',
                    'cantidad' => $detalle->cantidad,
                    'precio'   => $detalle->precio_unitario ?? $detalle->precio,
                ];
            }
        } else {
            //Simulamos datos de prueba con el total guardado si aún no configuras la tabla detalle o relaciones
            $cart[] = [
                'nombre'   => 'Nota de Venta #' . ($pedido->id_pedido ?? $id),
                'cantidad' => 1,
                'precio'   => $pedido->total ?? 0.00,
            ];
        }

        // Definimos el método de pago
        $metodo_pago = $pedido->metodo_pago ?? 'Efectivo';

        // 3. Cargamos la vista de tu ticket con los datos ensamblados
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticket', compact('cart', 'metodo_pago'));

        // 4. Configuramos el tamaño de papel para estilo Ticket (Ancho de 80mm en puntos / alto adaptable)
        $pdf->setPaper([0, 0, 226, 450]);

        // 5. Lo lanzamos como un stream para que se abra directo en el navegador
        return $pdf->stream('ticket-pedido-'.$id.'.pdf');
    }
}