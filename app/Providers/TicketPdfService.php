<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class TicketPdfService
{
    public function generar(array $cart)
    {
        // Configuración de altura
        $lineHeight = 20;   // altura aproximada por cada producto
        $baseHeight = 200;  // encabezado + totales + footer
        $altura = $baseHeight + count($cart) * $lineHeight;

        return Pdf::loadView('pdf.ticket', [
                'cart' => $cart
            ])
            ->setPaper([0, 0, 226.77, $altura], 'portrait');
    }
}
