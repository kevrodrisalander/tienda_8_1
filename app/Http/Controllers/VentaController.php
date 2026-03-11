<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Venta;
use App\Models\DetalleVenta;
// use App\Models\Producto;
use App\Models\Stock;

class VentaController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = $request->cart;

        if (!$cart || count($cart) === 0) {
            return response()->json(['error' => 'Carrito vacío'], 400);
        }

        // 1. Obtener el usuario autenticado y su ID de cliente vinculado
        $usuario = Auth::user();

        // Buscamos el ID en la tabla clientes.
        // Si no existe (ej. es un admin), usamos el 1 por defecto para evitar errores.
        $idCliente = ($usuario && $usuario->cliente) ? $usuario->cliente->id_cliente : 1;

        DB::beginTransaction();

        try {
            // 2. Calcular total real
            $total = collect($cart)->sum(fn($item) => $item['precio'] * $item['cantidad']);

            // 3. Crear venta con el ID de cliente DINÁMICO
            $venta = Venta::create([
                'fecha'       => now(),
                'total'       => $total,
                'id_cliente'  => $idCliente, // <-- Ya no es fijo, toma el del usuario logueado
                'metodo_pago' => 'EFECTIVO',
                'id_estatus'  => 1,
            ]);

            // 4. Detalle + salida de stock
            foreach ($cart as $item) {
                // Detalle de venta
                DetalleVenta::create([
                    'id_venta'        => $venta->id_venta,
                    'id_producto'     => $item['id'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                // Registro en Stock (Movimiento de salida)
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

            // 5. Generar PDF automáticamente
            // Cargamos la relación cliente para que el ticket pueda mostrar la dirección si lo necesitas
            $ventaConDetalles = Venta::with(['detalles.producto', 'cliente'])->findOrFail($venta->id_venta);
            $metodo_pago = $ventaConDetalles->metodo_pago;

            $cartData = $ventaConDetalles->detalles->map(fn($d) => [
                'nombre'   => $d->producto->descripcion,
                'cantidad' => $d->cantidad,
                'precio'   => $d->precio_unitario,
            ])->toArray();

            // El PDF ahora tiene acceso a $ventaConDetalles->cliente->direccion
            $pdf = Pdf::loadView('pdf.ticket', [
                'cart' => $cartData,
                'metodo_pago' => $metodo_pago,
                'venta' => $ventaConDetalles
            ])->setPaper([0, 0, 400.77, 600], 'portrait');

            return $pdf->stream("ticket_{$venta->id_venta}.pdf");
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'ok'    => false,
                'error' => 'Error en el checkout: ' . $e->getMessage()
            ], 500);
        }
    }


    public function ticketPdf($idVenta)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($idVenta);

        $cart = $venta->detalles->map(function ($d) {
            return [
                'nombre'   => $d->producto->nombre,
                'cantidad' => $d->cantidad,
                'precio'   => $d->precio_unitario,
            ];
        })->toArray();

        $pdf = Pdf::loadView('pdf.ticket', compact('cart'))
            ->setPaper([0, 0, 226.77, 600], 'portrait');

        return $pdf->stream("ticket_{$idVenta}.pdf");
    }
}
