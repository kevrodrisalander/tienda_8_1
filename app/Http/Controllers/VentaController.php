<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Stock;
use App\Models\Pedido;

class VentaController extends Controller
{
  public function checkout(Request $request)
{
    // 1. Validar primero si el usuario está realmente logueado
    if (!Auth::check()) {
        return response()->json([
            'error' => 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.'
        ], 401); // 401 significa No Autorizado (Evita la redirección HTML)
    }

    $cart = $request->cart;

    if (!$cart || count($cart) === 0) {
        return response()->json(['error' => 'Carrito vacío'], 400);
    }

    // Obtener el usuario ahora que estamos 100% seguros de que existe
    $usuario = Auth::user();
    $idCliente = ($usuario && $usuario->cliente) ? $usuario->cliente->id_cliente : 1;

    DB::beginTransaction();

        try {
            // 1. Calcular total real
            $total = collect($cart)->sum(fn($item) => $item['precio'] * $item['cantidad']);

            // 2. Crear venta
            $venta = Venta::create([
                'fecha'       => now(),
                'total'       => $total,
                'id_cliente'  => $idCliente,
                'metodo_pago' => 'EFECTIVO',
                'id_estatus'  => 1,
            ]);

            // 3. Detalle + salida de stock
            foreach ($cart as $item) {
                DetalleVenta::create([
                    'id_venta'        => $venta->id_venta,
                    'id_producto'     => $item['id'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                Stock::create([
                    'producto_id'     => $item['id'],
                    'cantidad'        => $item['cantidad'],
                    'tipo_movimiento' => 'salida',
                    'estado'          => 'disponible',
                    'usuario_id'      => Auth::id(),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                    'fecha_salida'    => now(),
                ]);
            }

            DB::commit();

//Buscamos el ID de forma dinámica por si el modelo no tiene configurado el primaryKey
            $idFinal = $venta->id_venta ?? $venta->id_venta_generado ?? $venta->id ?? null;

            if (!$idFinal) {
                return response()->json([
                    'error' => 'La venta se guardó, pero no se pudo recuperar el ID. Revisa el $primaryKey en el Modelo Venta.'
                ], 500);
            }

            return response()->json([
                'id_pedido' => $idFinal
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'ok'    => false,
                'error' => 'Error en el checkout: ' . $e->getMessage()
            ], 500);
        }
    }

    // Este método se encargará EXCLUSIVAMENTE de renderizar el PDF en la pestaña nueva
    public function ticketPdf($idVenta)
    {
        // Cargamos la venta con sus productos y también intentamos cargar su envío asociado
        $venta = Venta::with(['detalles.producto', 'envio'])->findOrFail($idVenta);

        $cart = $venta->detalles->map(function ($d) {
            return [
                'nombre'   => $d->producto->descripcion ?? $d->producto->nombre,
                'cantidad' => $d->cantidad,
                'precio'   => $d->precio_unitario,
            ];
        })->toArray();

        // Mandamos la venta completa a la vista del ticket para mapear si tiene dirección
        $pdf = Pdf::loadView('pdf.ticket', [
            'cart' => $cart,
            'venta' => $venta,
            'metodo_pago' => $venta->metodo_pago
        ])->setPaper([0, 0, 400.77, 600], 'portrait');

        return $pdf->stream("ticket_{$idVenta}.pdf");
    }


}
