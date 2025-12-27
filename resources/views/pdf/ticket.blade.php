<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Ticket de compra</title>

    <style>
        body {
            font-family: "Courier New", monospace;
            font-size: 11px;
            color: #020202;
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 280px;
            margin: auto;
            padding: 10px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 2px 0;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 3px 0;
            font-size: 11px;
        }

        th {
            text-align: left;
        }

        td.right,
        th.right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            text-align: right;
            font-size: 12px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="ticket">

        <h2>CHERRY TIENDA</h2>
        <h3>TICKET DE COMPRA</h3>

        <p class="center">
            {{ now()->format('d/m/Y H:i') }}
        </p>

        <div class="line"></div>

        <table>
            <thead>
                <tr>
                    <th>Prod</th>
                    <th class="right">Cant</th>
                    <th class="right">Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td class="right">{{ $item['cantidad'] }}</td>
                        <td class="right">
                            ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line"></div>
        <p class="center">
            Tipo de pago: {{ $metodo_pago }}
        </p>

        <p class="total">
            TOTAL: ${{ number_format(collect($cart)->sum(fn($i) => $i['precio'] * $i['cantidad']), 2) }}
        </p>

        <div class="line"></div>

        <div class="footer">
            ¡Gracias por su compra!<br>
            www.cherrytienda.com
        </div>

    </div>

</body>

</html>
