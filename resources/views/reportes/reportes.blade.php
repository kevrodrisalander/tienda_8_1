@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-gray-800">Reporte de Inventario</h1>
            <button id="btnExportarExcel" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i> Exportar a Excel
            </button>
        </div>

        <!-- Panel de Filtros -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filtros de Búsqueda</h6>
            </div>
            <div class="card-body">
                <form id="formFiltrosReportes" class="row g-3">
                    <div class="col-md-4">
                        <label for="filter_nombre" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="filter_nombre" placeholder="Buscar por nombre...">
                    </div>
                    <div class="col-md-4">
                        <label for="filter_ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="filter_ubicacion" placeholder="Buscar por ubicación...">
                    </div>
                    <div class="col-md-4">
                        <label for="filter_estado" class="form-label">Estado</label>
                        <select class="form-select" id="filter_estado">
                            <option value="">-- Todos --</option>
                            <option value="Disponible">Disponible</option>
                            <option value="Reservado">Reservado</option>
                            <option value="Agotado">Agotado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter_lote" class="form-label">Lote</label>
                        <input type="text" class="form-control" id="filter_lote" placeholder="Número de lote...">
                    </div>
                    <div class="col-md-4">
                        <label for="filter_fecha_ingreso_desde" class="form-label">Fecha Desde</label>
                        <input type="date" class="form-control" id="filter_fecha_ingreso_desde">
                    </div>
                    <div class="col-md-4">
                        <label for="filter_fecha_ingreso_hasta" class="form-label">Fecha Hasta</label>
                        <input type="date" class="form-control" id="filter_fecha_ingreso_hasta">
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <button type="button" id="btnLimpiarFiltros" class="btn btn-secondary">
                            <i class="fas fa-undo me-1"></i> Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Resultados -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tblReportes" class="table table-bordered table-striped align-middle w-100"
                        data-url-consulta="{{ route('stock.consulta') }}"
                        data-url-exportar="{{ route('stock.exportarExcel') }}">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Lote</th>
                                <th>Cantidad</th>
                                <th>Mín. Seguro</th>
                                <th>Ubicación</th>
                                <th>Estado</th>
                                <th>Movimiento</th>
                                <th>Fecha Ingreso</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_footer')
    <script src="{{ asset('js/reportes.js') }}"></script>
@endsection
