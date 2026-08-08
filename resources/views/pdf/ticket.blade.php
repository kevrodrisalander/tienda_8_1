<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de compra</title>
    <style>
        @page { margin: 8px 9px 12px; }
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1f2933; margin: 0; }
        .ticket { width: 100%; }
        .header { text-align: center; border-bottom: 2px solid #222; padding-bottom: 6px; }
        .logo { display: block; width: 54px; height: 54px; object-fit: contain; margin: 0 auto 2px; }
        h1 { font-size: 15px; letter-spacing: 1px; margin: 0; }
        .subtitle { font-size: 8px; letter-spacing: 1.5px; margin: 1px 0 0; }
        p { margin: 3px 0; }
        .center { text-align: center; }
        .sale-info { background: #f0f0f0; border: 1px solid #888; text-align: center; margin: 7px 0; padding: 5px 3px; }
        .sale-type { font-size: 10px; font-weight: bold; letter-spacing: .4px; }
        .date { font-size: 8px; margin-top: 2px; }
        .line { border-top: 1px dashed #555; margin: 7px 0; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { padding: 4px 2px; vertical-align: top; overflow-wrap: break-word; }
        th { color: #fff; background: #242424; font-size: 7px; text-transform: uppercase; }
        tbody tr:nth-child(even) td { background: #f3f3f3; }
        tbody td { border-bottom: 1px dotted #bbb; }
        .product { width: 42%; }
        .qty { width: 12%; text-align: center; }
        .money { width: 23%; text-align: right; white-space: nowrap; }
        .payment { font-size: 8px; }
        .total-box { border: 2px solid #222; margin-top: 7px; padding: 6px 5px; text-align: right; }
        .total-label { font-size: 8px; letter-spacing: 1px; }
        .total { font-size: 14px; font-weight: bold; margin-top: 1px; }
        .footer { text-align: center; margin-top: 9px; font-size: 8px; line-height: 1.5; }
        .thanks { font-size: 10px; font-weight: bold; }
        .small { font-size: 7px; color: #444; }
    </style>
</head>
<body>
<div class="ticket">
    <div class="header">
        <img class="logo" src="{{ public_path('icono.png') }}" alt="Cherry Tienda">
        <h1>CHERRY TIENDA</h1>
        <p class="subtitle">TICKET DE COMPRA</p>
    </div>

    <div class="sale-info">
        @if(($esEnvio ?? false) && isset($pedido))
            <div class="sale-type">ENVÍO · PEDIDO #{{ $pedido->id_pedido }}</div>
        @else
            <div class="sale-type">VENTA EN TIENDA</div>
        @endif
        <div class="date">{{ now()->format('d/m/Y · H:i') }} h</div>
    </div>

    <table>
        <thead>
        <tr>
            <th class="product">Producto</th>
            <th class="qty">Cant.</th>
            <th class="money">P. unit.</th>
            <th class="money">Importe</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cart as $item)
            <tr>
                <td class="product">{{ $item['nombre'] }}</td>
                <td class="qty">{{ $item['cantidad'] }}</td>
                <td class="money">${{ number_format($item['precio'], 2) }}</td>
                <td class="money">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p class="payment"><strong>Forma de pago:</strong> {{ ucfirst(strtolower($metodo_pago ?? 'Efectivo')) }}</p>
    <div class="total-box">
        <div class="total-label">TOTAL</div>
        <div class="total">${{ number_format(collect($cart)->sum(fn($i) => $i['precio'] * $i['cantidad']), 2) }} MXN</div>
    </div>

    <div class="footer">
        <div class="thanks">¡GRACIAS POR SU COMPRA!</div>
        <div>Esperamos verle pronto</div>
        <div class="line"></div>
        <div class="small">www.cherrytienda.com</div>
    </div>
</div>
</body>
</html>
