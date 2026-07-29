<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReporteController extends Controller
{
    // Vista específica para la categoría// ReporteController.php
    public function index()
    {
        return view('reportes/reportes');
    }

    public function lista(Request $request)
    {
        $query = DB::table('ventas')
            ->join('proveedores', 'ventas.id_proveedor', '=', 'proveedores.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id');

        if ($request->fecha_inicio) {
            $query->whereDate('ventas.fecha', '>=', $request->fecha_inicio);
        }
        if ($request->fecha_fin) {
            $query->whereDate('ventas.fecha', '<=', $request->fecha_fin);
        }
        if ($request->proveedor) {
            $query->where('ventas.id_proveedor', $request->proveedor);
        }

        $reportes = $query->select(
            'ventas.id',
            'proveedores.nombre as proveedor',
            'productos.nombre as producto',
            'ventas.cantidad',
            'ventas.precio_unitario',
            DB::raw('ventas.cantidad * ventas.precio_unitario as total'),
            'ventas.fecha'
        )->get();

        return response()->json(['data' => $reportes]);
    }
}
