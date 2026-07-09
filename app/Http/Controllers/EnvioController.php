<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;

class EnvioController extends Controller
{
    public function index()
    {
        $envios = Envio::with('pedido')->get();
        return view('envios', compact('envios'));
    }

    public function consulta()
    {
        $envios = Envio::with('pedido')->get();

        $data = $envios->map(function ($envio) {
            return [
                'id_envio'      => $envio->id_envio,
                'id_pedido'     => $envio->id_pedido,
                'fecha_pedido'  => $envio->pedido->fecha_pedido,
                'fecha_envio'   => $envio->fecha_envio,
                'transportista' => $envio->transportista,
                'numero_guia'   => $envio->numero_guia,
                'estado_pedido' => $envio->pedido->estado,
                'estado_envio'  => $envio->estado_envio,
            ];
        });

        return response()->json(['data' => $data]);
    }

public function guardarInfo(Request $request)
    {
        // 1. Validamos los datos mínimos requeridos para evitar fallos de base de datos
        if (!$request->has('id_pedido') || empty($request->id_pedido)) {
            return response()->json([
                'success' => false,
                'error' => 'El identificador del pedido está ausente en la petición.'
            ], 400);
        }

        try {
            // 2. Intentamos realizar el registro del domicilio
            Envio::create([
                'id_pedido'    => $request->id_pedido,
                'direccion'    => $request->direccion,
                'telefono'     => $request->telefono,
                'referencias'  => $request->referencias,
                'estado_envio' => 'preparando',
                'fecha_envio'  => now()
            ]);

            // Retornamos true para acoplar con tu JS
            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {
            // 3. Si ocurre un error de SQL (ej: campos nulos o llaves foráneas), lo atrapamos aquí
            return response()->json([
                'success' => false,
                'error'   => 'Error en base de datos: ' . $e->getMessage()
            ], 500);
        }
    }

}
