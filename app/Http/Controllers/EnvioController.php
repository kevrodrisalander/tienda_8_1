<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;   // ✅ importación correcta
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
    Envio::create([
        'id_pedido'   => $request->id_pedido, // 👈 ya no es null
        'direccion'   => $request->direccion,
        'telefono'    => $request->telefono,
        'referencias' => $request->referencias,
        'estado_envio'=> 'preparando',
        'fecha_envio' => now()
    ]);

    return response()->json(['success' => true]);
}

}