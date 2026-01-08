<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


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
            // 🔹 calcular total real
            $total = collect($cart)->sum(fn($item) => $item['precio'] * $item['cantidad']);

            // 🔹 crear venta
            $venta = Venta::create([
                'fecha'       => now(),
                'total'       => $total,
                'id_cliente'  => 1,
                'metodo_pago' => 'EFECTIVO',
                'id_estatus'  => 1,
            ]);

            // 🔹 detalle + salida de stock
            foreach ($cart as $item) {
                // Detalle de venta
                DetalleVenta::create([
                    'id_venta'        => $venta->id_venta,
                    'id_producto'     => $item['id'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                Stock::create([
                    'producto_id'    => $item['id'],
                    'cantidad'       => $item['cantidad'], // siempre positivo
                    'tipo_movimiento' => 'salida',          // aquí va 'entrada' o 'salida'
                    'estado'         => 'disponible',
                    'usuario_id'     => Auth::id(), // <- aquí pones el ID del usuario actual
                    'created_at'     => now(),
                    'updated_at'     => now(),
                    'fecha_salida'    => now(), // <--- aquí va la fecha real de salida
                ]);
            }

            DB::commit();

            // 🔹 generar PDF automáticamente
            $ventaConDetalles = Venta::with('detalles.producto')->findOrFail($venta->id_venta);
            $metodo_pago = $ventaConDetalles->metodo_pago;


            $cart = $ventaConDetalles->detalles->map(fn($d) => [
                'nombre'   => $d->producto->descripcion,
                'cantidad' => $d->cantidad,
                'precio'   => $d->precio_unitario,
            ])->toArray();

            $pdf = Pdf::loadView('pdf.ticket', compact('cart','metodo_pago'))
                ->setPaper([0, 0, 400.77, 600], 'portrait');

            return $pdf->stream("ticket_{$venta->id_venta}.pdf");
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'ok'    => false,
                'error' => $e->getMessage()
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
