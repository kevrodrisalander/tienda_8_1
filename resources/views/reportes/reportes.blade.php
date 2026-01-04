@extends('layouts.app')
@section('title', 'Reportes')

@section('content')
    <div class="container">
        <h1 class="mb-4">Reportes</h1>

        {{-- Filtros --}}
        <div class="card mb-4">
            <div class="card-header">Filtros</div>
            <div class="card-body">
                <form id="formFiltrosReportes" class="row g-3">
                    <div class="col-md-3">
                        <label for="filtroFechaInicio" class="form-label">Fecha Inicio</label>
                        <input type="date" id="filtroFechaInicio" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="filtroFechaFin" class="form-label">Fecha Fin</label>
                        <input type="date" id="filtroFechaFin" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="filtroProveedor" class="form-label">Proveedor</label>
                        <select id="filtroProveedor" class="form-select">
                            <option value="">Todos</option>
                            {{-- Opciones cargadas dinámicamente --}}
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Aplicar Filtros</button>
                        <button type="button" id="btnLimpiarFiltros" class="btn btn-secondary">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabla de reportes --}}
        <div class="card">
            <div class="card-header">Resultados</div>
            <div class="card-body">
                <table id="tblReportes" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Se llena con DataTables --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            const tabla = $("#tblReportes").DataTable({
                language: { url: "/es-MX.json" },
                pageLength: 10,
                ajax: {
                    url: "/reportes/lista",
                    type: "GET",
                    data: function (d) {
                        d.fecha_inicio = $("#filtroFechaInicio").val();
                        d.fecha_fin = $("#filtroFechaFin").val();
                        d.proveedor = $("#filtroProveedor").val();
                    }
                },
                columns: [
                    { data: "id" },
                    { data: "proveedor" },
                    { data: "producto" },
                    { data: "cantidad" },
                    { data: "precio_unitario" },
                    { data: "total" },
                    { data: "fecha" }
                ]
            });

            // Aplicar filtros
            $("#formFiltrosReportes").on("submit", function (e) {
                e.preventDefault();
                tabla.ajax.reload();
            });

            // Limpiar filtros
            $("#btnLimpiarFiltros").on("click", function () {
                $("#filtroFechaInicio, #filtroFechaFin, #filtroProveedor").val("");
                tabla.ajax.reload();
            });

            // Cargar proveedores dinámicamente
            $.get("/provedores/lista", function (data) {
                const select = $("#filtroProveedor");
                data.data.forEach(function (proveedor) {
                    select.append(`<option value="${proveedor.id_proveedor}">${proveedor.nombre_proveedor}</option>`);
                });
            });
        });
    </script>
@endsection
