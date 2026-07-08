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
        // 🔒 1. Validar sesión manualmente para evitar redirecciones del middleware auth
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.'
            ], 401);
        }

        // 🛍️ 2. Validar que el carrito llegue en la petición AJAX sin redirigir
        if (!$request->has('cart') || empty($request->cart)) {
            return response()->json([
                'error' => 'El carrito está vacío o no se recibieron los productos.'
            ], 400);
        }

        try {
            // 📝 3. Creamos el pedido básico con el cliente logueado
            $pedido = Pedido::create([
                'id_cliente'   => Auth::id(),
                'fecha_pedido' => now(),
                'estado'       => 'pendiente'
            ]);

            // 🔍 Aseguramos capturar la clave primaria correcta de tu modelo Pedido
            $idFinal = $pedido->id_pedido ?? $pedido->id ?? null;

            if (!$idFinal) {
                return response()->json([
                    'error' => 'El pedido se creó pero no se pudo recuperar su ID. Revisa el $primaryKey en tu Modelo Pedido.'
                ], 500);
            }

            // 🎉 4. Retornamos con éxito el ID del pedido en formato JSON limpio
            return response()->json([
                'id_pedido' => $idFinal
            ]);

        } catch (\Exception $e) {
            // Si algo truena en la base de datos, respondemos con JSON, NUNCA con redirección HTML
            return response()->json([
                'error' => 'Error al procesar la compra en la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🎫 ¡ESTA ES LA FUNCIÓN QUE LE FALTABA A TU CONTROLADOR!
  public function descargarTicket($id)
    {
        // 1. Buscamos el pedido con los detalles de los productos vendidos
        // Nota: Asegúrate de que tu modelo Pedido tenga la relación 'detalles' o similar.
        // Si no la tienes configurada, abajo extraemos los datos de forma segura.
        $pedido = \App\Models\Pedido::find($id);

        if (!$pedido) {
            abort(404, 'El pedido no existe.');
        }

        // 2. Mapeamos los datos para que coincidan exactamente con tu estructura Blade ($cart)
        // Si tienes una tabla 'detalle_pedidos' o 'ventas_detalles', la recorremos aquí:
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
            // 💡 Simulamos datos de prueba con el total guardado si aún no configuras la tabla detalle
            $cart[] = [
                'nombre'   => 'Nota de Venta #' . $pedido->id_pedido,
                'cantidad' => 1,
                'precio'   => $pedido->total ?? 0.00,
            ];
        }

        // Definimos el método de pago (puedes jalarlo de una columna de tu base de datos)
        $metodo_pago = $pedido->metodo_pago ?? 'Efectivo';

        // 3. Cargamos la vista de tu ticket con los datos ensamblados
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticket', compact('cart', 'metodo_pago'));

        // 4. Configuramos el tamaño de papel para estilo Ticket (Ancho aproximado de 80mm en puntos)
        // El tamaño de rollo de ticket normal suele ser de 226pt de ancho por la altura que requiera el contenido
        $pdf->setPaper([0, 0, 226, 450]);

        // 5. Lo lanzamos como un stream para que se abra directo en el navegador
        return $pdf->stream('ticket-pedido-'.$id.'.pdf');
    }
}
