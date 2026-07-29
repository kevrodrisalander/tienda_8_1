<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected array $filters;

    // Recibimos un array simple con los filtros en lugar de la Request
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
{
    $query = DB::table('stock')
        ->join(
            'productos',
            'stock.producto_id',
            '=',
            'productos.id'
        )
        ->leftJoin(
            'lotes_producto',
            'stock.id_lote',
            '=',
            'lotes_producto.id_lote'
        );

    /*
    |--------------------------------------------------------------------------
    | Activos o eliminados
    |--------------------------------------------------------------------------
    */

    if (
        isset($this->filters['eliminados']) &&
        (int) $this->filters['eliminados'] === 1
    ) {
        $query->where('stock.activo', 0);
    } else {
        $query->where('stock.activo', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | Nombre del producto
    |--------------------------------------------------------------------------
    */

    if (!empty($this->filters['filter_nombre'])) {
        $nombre = trim($this->filters['filter_nombre']);

        $query->where(
            'productos.descripcion',
            'ILIKE',
            '%' . $nombre . '%'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Ubicación
    |--------------------------------------------------------------------------
    */

    if (!empty($this->filters['filter_ubicacion'])) {
        $ubicacion = trim($this->filters['filter_ubicacion']);

        $query->where(
            'stock.ubicacion',
            'ILIKE',
            '%' . $ubicacion . '%'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Lote
    |--------------------------------------------------------------------------
    */

    if (!empty($this->filters['filter_lote'])) {
        $lote = trim($this->filters['filter_lote']);

        $query->where(
            'lotes_producto.codigo_lote',
            'ILIKE',
            '%' . $lote . '%'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Estado
    |--------------------------------------------------------------------------
    */

    if (!empty($this->filters['filter_estado'])) {
        $estado = strtolower(
            trim($this->filters['filter_estado'])
        );

        $query->whereRaw(
            'LOWER(TRIM(stock.estado)) = ?',
            [$estado]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Tipo de movimiento
    |--------------------------------------------------------------------------
    */

    if (!empty($this->filters['filter_tipo_movimiento'])) {
        $tipoMovimiento = strtolower(
            trim($this->filters['filter_tipo_movimiento'])
        );

        $query->whereRaw(
            'LOWER(TRIM(stock.tipo_movimiento)) = ?',
            [$tipoMovimiento]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Cantidades
    |--------------------------------------------------------------------------
    */

    if (
        isset($this->filters['filter_cantidad_min']) &&
        $this->filters['filter_cantidad_min'] !== ''
    ) {
        $query->where(
            'stock.cantidad',
            '>=',
            $this->filters['filter_cantidad_min']
        );
    }

    if (
        isset($this->filters['filter_cantidad_max']) &&
        $this->filters['filter_cantidad_max'] !== ''
    ) {
        $query->where(
            'stock.cantidad',
            '<=',
            $this->filters['filter_cantidad_max']
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Fechas
    |--------------------------------------------------------------------------
    */

    if (!empty($this->filters['filter_fecha_ingreso_desde'])) {
        $query->whereDate(
            'stock.fecha_ingreso',
            '>=',
            $this->filters['filter_fecha_ingreso_desde']
        );
    }

    if (!empty($this->filters['filter_fecha_ingreso_hasta'])) {
        $query->whereDate(
            'stock.fecha_ingreso',
            '<=',
            $this->filters['filter_fecha_ingreso_hasta']
        );
    }

    return $query
        ->select([
            'stock.id',
            'productos.descripcion as nombre_producto',
            'lotes_producto.codigo_lote as lote',
            'stock.cantidad',
            'stock.minimo_seguro',
            'stock.maximo_permitido',
            'stock.ubicacion',
            'stock.estado',
            'stock.tipo_movimiento',
            'stock.fecha_ingreso',
            'stock.fecha_vencimiento',
            'stock.observaciones',
        ])
        ->orderByDesc('stock.id');
}

    public function headings(): array
    {
        return [
            'ID',
            'Producto',
            'Lote',
            'Cantidad',
            'Mínimo Seguro',
            'Máximo Permitido',
            'Ubicación',
            'Estado',
            'Tipo Movimiento',
            'Fecha Ingreso',
            'Fecha Vencimiento',
            'Observaciones',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->nombre_producto,
            $row->lote ?? 'N/A',
            $row->cantidad,
            $row->minimo_seguro,
            $row->maximo_permitido,
            $row->ubicacion,
            ucfirst($row->estado ?? ''),
            ucfirst($row->tipo_movimiento ?? ''),
            $row->fecha_ingreso,
            $row->fecha_vencimiento ?? 'N/A',
            $row->observaciones,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E293B']
                ],
            ],
        ];
    }
}
