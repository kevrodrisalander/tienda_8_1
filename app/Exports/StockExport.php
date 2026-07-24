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
            ->join('productos', 'stock.producto_id', '=', 'productos.id')
            ->leftJoin('lotes_producto', 'stock.id_lote', '=', 'lotes_producto.id_lote');

        // Filtro base: Activos / Eliminados
        if (isset($this->filters['eliminados']) && $this->filters['eliminados'] == 1) {
            $query->where('stock.activo', 0);
        } else {
            $query->where('stock.activo', 1);
        }

        // Filtros dinámicos usando filled/empty sobre el array
        $query->when(!empty($this->filters['filter_nombre']), function ($q) {
            return $q->where('productos.descripcion', 'LIKE', '%' . $this->filters['filter_nombre'] . '%');
        });

        $query->when(!empty($this->filters['filter_ubicacion']), function ($q) {
            return $q->where('stock.ubicacion', 'LIKE', '%' . $this->filters['filter_ubicacion'] . '%');
        });

        $query->when(!empty($this->filters['filter_lote']), function ($q) {
            return $q->where('lotes_producto.codigo_lote', 'LIKE', '%' . $this->filters['filter_lote'] . '%');
        });

        $query->when(!empty($this->filters['filter_estado']), function ($q) {
            return $q->whereRaw('LOWER(stock.estado) = ?', [strtolower($this->filters['filter_estado'])]);
        });

        $query->when(!empty($this->filters['filter_tipo_movimiento']), function ($q) {
            return $q->whereRaw('LOWER(stock.tipo_movimiento) = ?', [strtolower($this->filters['filter_tipo_movimiento'])]);
        });

        $query->when(!empty($this->filters['filter_cantidad_min']), function ($q) {
            return $q->where('stock.cantidad', '>=', $this->filters['filter_cantidad_min']);
        });

        $query->when(!empty($this->filters['filter_cantidad_max']), function ($q) {
            return $q->where('stock.cantidad', '<=', $this->filters['filter_cantidad_max']);
        });

        $query->when(!empty($this->filters['filter_fecha_ingreso_desde']), function ($q) {
            return $q->whereDate('stock.fecha_ingreso', '>=', $this->filters['filter_fecha_ingreso_desde']);
        });

        $query->when(!empty($this->filters['filter_fecha_ingreso_hasta']), function ($q) {
            return $q->whereDate('stock.fecha_ingreso', '<=', $this->filters['filter_fecha_ingreso_hasta']);
        });

        return $query->select([
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
        ->orderBy('stock.id', 'desc');
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