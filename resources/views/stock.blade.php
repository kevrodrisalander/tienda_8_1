@extends('layouts.app')

{{--
<link rel="stylesheet" href="{{ asset('css/tablas.css') }}"> --}}
@vite('resources/css/tablas.css')

@section('title', 'Stock')

@section('content')
    <div class="container">
        <b>
            <h2 class="text-center my-5">Stock</h2>
        </b>

        <b>
            <p class="text-center">Listado del stock de productos registrados</p>
        </b>

        {{-- Botón Agregar producto solo para roles permitidos --}}
        @if(auth()->check() && in_array(auth()->user()->id_rol, [1, 4, 8]))
            {{-- <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                Agregar producto
            </button> --}}
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                <i class="bi bi-plus-circle me-2"></i> Agregar producto
            </button>
        @endif
        {{-- b --}}
        {{-- Botón Filtros visible para todos --}}
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalFiltros">
            <i class="bi bi-funnel"></i> Filtros
        </button>

        {{-- Ver eliminados solo para roles permitidos --}}
        @if(auth()->check() && in_array(auth()->user()->id_rol, [1, 4]))
            <button id="btnVerEliminados" class="btn btn-danger mb-3">
                <i class="bi bi-file-earmark-x"></i>Ver eliminados
            </button>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    {{-- <div class="row"> --}}
                        <div class="table-responsive">
                            <table class="table_id" id="tbl_stock">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre de producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Ubicación</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Mínimo seguro</th>
                                        <th class="text-center">Máximo permitido</th>
                                        <th class="text-center">Fecha ingreso</th>
                                        <th class="text-center">Fecha vencimiento</th>
                                        <th class="text-center">Lote</th>
                                        <th class="text-center">Fecha Salida</th>
                                        <th class="text-center">Observaciones</th>
                                        <th class="text-center">Tipo movimiento</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection

    {{-- Modal nuevo producto solo para roles permitidos --}}
    @if(auth()->check() && in_array(auth()->user()->id_rol, [1, 4, 8]))
        <div class="modal fade modal-producto" id="modalNuevoProducto" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ route('producto.guardar') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Registrar nuevo producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Nombre del producto</label>
                                    <input type="text" name="nombre_producto" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Cantidad inicial</label>
                                    <input type="number" name="cantidad_inicial" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Precio de venta</label>
                                    <input type="number" name="precio_venta" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Cantidad mínima</label>
                                    <input type="number" name="cantidad_minima" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Cantidad máxima</label>
                                    <input type="number" name="cantidad_maxima" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" class="form-select" required>
                                        <option value="">Seleccione estado</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Marca</label>
                                    <select name="id_marca" class="form-select" required>
                                        <option value="">Seleccione marca</option>
                                        @foreach ($marcas as $marca)
                                            <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Categoría</label>
                                    <select name="id_categoria" class="form-select" required>
                                        <option value="">Seleccione categoría</option>
                                        @foreach ($categorias as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->categoria }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Lote</label>
                                    <input type="text" name="nuevo_lote" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ubicación</label>
                                    <input type="text" name="ubicacion" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tipo movimiento</label>
                                    <select name="tipo_movimiento" class="form-select" required>
                                        <option value="">Seleccione tipo</option>
                                        @foreach ($tiposMovimiento as $valor => $etiqueta)
                                            <option value="{{ $valor }}">{{ $etiqueta }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha ingreso</label>
                                    <input type="date" name="fecha_ingreso" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha vencimiento</label>
                                    <input type="date" name="fecha_vencimiento" class="form-control" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Observaciones</label>
                                    <input type="text" name="observaciones" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Imagen del producto</label>
                                    <input type="file" name="imagen" class="form-control" accept="image/*">
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Guardar</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal editar stock solo para roles permitidos --}}
    @if(auth()->check() && in_array(auth()->user()->id_rol, [1, 4, 8]))
        <div class="modal fade" id="modalSimple" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formEditarStock" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title">Actualizar stock</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">

                                <div class="col-md-8">
                                    <label class="form-label">Producto</label>
                                    <input type="text" id="producto_nombre" class="form-control" disabled>
                                    <input type="hidden" name="producto_id">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Cantidad</label>
                                    <input type="number" name="cantidad" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Ubicación</label>
                                    <input type="text" name="ubicacion" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <select name="estado" class="form-select">
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Lote</label>
                                    <select name="id_lote" class="form-select">
                                        @foreach ($lotes as $lote)
                                            <option value="{{ $lote->id_lote }}">{{ $lote->codigo_lote }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Mínimos</label>
                                    <input type="number" name="minimos" class="form-control">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Máximos</label>
                                    <input type="number" name="maximos" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha ingreso</label>
                                    <input type="date" name="fecha_ingreso" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha vencimiento</label>
                                    <input type="date" name="fecha_vencimiento" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tipo movimiento</label>
                                    <select name="tipo_movimiento" class="form-select">
                                        @foreach ($tiposMovimiento as $valor => $etiqueta)
                                            <option value="{{ $valor }}">{{ $etiqueta }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Observaciones</label>
                                    <input type="text" name="observaciones" class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Guardar</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        {{-- Modal Filtros Avanzados para DataTables --}}

        <div class="modal fade modal-producto" id="modalFiltros" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formFiltrosStock">
                        <div class="modal-header">
                            <h5 class="modal-title">Filtrar Listado de Stock</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">

                                {{-- Filtro por Nombre de Producto --}}
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del producto</label>
                                    <input type="text" name="filter_nombre" class="form-control"
                                        placeholder="Buscar por nombre...">
                                </div>

                                {{-- Filtro por Ubicación --}}
                                <div class="col-md-6">
                                    <label class="form-label">Ubicación</label>
                                    <input type="text" name="filter_ubicacion" class="form-control"
                                        placeholder="Ej: Estante A1">
                                </div>

                                {{-- Filtro por Lote --}}
                                <div class="col-md-4">
                                    <label class="form-label">Lote</label>
                                    <input type="text" name="filter_lote" class="form-control"
                                        placeholder="Código de lote...">
                                </div>

                                {{-- Filtro por Estado --}}
                                <div class="col-md-4">
                                    <label class="form-label">Estado</label>
                                    <select name="filter_estado" class="form-select">
                                        <option value="">Todos los estados</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Filtro por Tipo de Movimiento --}}
                                <div class="col-md-4">
                                    <label class="form-label">Tipo movimiento</label>
                                    <select name="filter_tipo_movimiento" class="form-select">
                                        <option value="">Todos los tipos</option>
                                        @foreach ($tiposMovimiento as $valor => $etiqueta)
                                            <option value="{{ $valor }}">{{ $etiqueta }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <hr class="my-3 text-muted">
                                <h6 class="fw-bold mb-0">Rangos de Cantidades</h6>

                                {{-- Rango de Cantidad --}}
                                <div class="col-md-6">
                                    <label class="form-label">Cantidad (Desde - Hasta)</label>
                                    <div class="input-group">
                                        <input type="number" name="filter_cantidad_min" class="form-control"
                                            placeholder="Min">
                                        <input type="number" name="filter_cantidad_max" class="form-control"
                                            placeholder="Max">
                                    </div>
                                </div>

                                {{-- Límites de Seguridad --}}
                                <div class="col-md-3">
                                    <label class="form-label">Mínimo Seguro</label>
                                    <input type="number" name="filter_minimo" class="form-control" placeholder="Ej: 5">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Máximo Permitido</label>
                                    <input type="number" name="filter_maximo" class="form-control" placeholder="Ej: 100">
                                </div>

                                <hr class="my-3 text-muted">
                                <h6 class="fw-bold mb-0">Rangos de Fechas</h6>

                                {{-- Rango de Fecha de Ingreso --}}
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Ingreso (Desde / Hasta)</label>
                                    <div class="input-group">
                                        <input type="date" name="filter_fecha_ingreso_desde" class="form-control">
                                        <input type="date" name="filter_fecha_ingreso_hasta" class="form-control">
                                    </div>
                                </div>

                                {{-- Rango de Fecha de Vencimiento --}}
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Vencimiento (Desde / Hasta)</label>
                                    <div class="input-group">
                                        <input type="date" name="filter_fecha_vencimiento_desde" class="form-control">
                                        <input type="date" name="filter_fecha_vencimiento_hasta" class="form-control">
                                    </div>
                                </div>

                                {{-- Filtro por Observaciones --}}
                                <div class="col-md-12">
                                    <label class="form-label">Observaciones (Contiene texto)</label>
                                    <input type="text" name="filter_observaciones" class="form-control"
                                        placeholder="Buscar palabras clave en observaciones...">
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="btnLimpiarFiltros" class="btn btn-outline-danger">Limpiar
                                Filtros</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Aplicar Filtros</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- JS --}}
    @section('js_footer')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/tienda/stock.js') }}"></script>
    @endsection
