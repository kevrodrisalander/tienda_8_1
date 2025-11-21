<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket de compra</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2, h3 {
            text-align: center;
            margin: 0;
        }

        .ticket-header {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #ddd9d9;
            border-bottom: 2px solid #e7abab;
        }

        td {
            border-bottom: 1px solid #e7abab;
        }

        .total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #1f1e1e;
        }
    </style>
</head>
<body>

<div class="ticket-header">
    <h2>Cherry Tienda </h2>
    <h3>Ticket de Compra</h3>
    <p style="text-align:center;">
        Fecha: {{ now()->format('d/m/Y H:i') }}
    </p>
</div>

<table>
    <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Subtotal</th>
    </tr>

    @foreach($cart as $item)
    <tr>
        <td>{{ $item['nombre'] }}</td>
        <td>{{ $item['cantidad'] }}</td>
        <td>${{ number_format($item['precio'], 2) }}</td>
        <td>${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
    </tr>
    @endforeach
</table>

<p class="total">
    Total: ${{ number_format(collect($cart)->sum(fn($i) => $i['precio'] * $i['cantidad']), 2) }}
</p>

<div class="footer">
    ¡Gracias por su compra!<br>
    www.mitienda.com
</div>

</body>
</html>
