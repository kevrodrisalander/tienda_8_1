@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

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
        @if(auth()->check() && in_array(auth()->user()->id_rol, [1,4,8]))
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                Agregar producto
            </button>
        @endif

        {{-- Botón Filtros visible para todos --}}
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalFiltros">
            Filtros
        </button>

        {{-- Ver eliminados solo para roles permitidos --}}
        @if(auth()->check() && in_array(auth()->user()->id_rol, [1,4]))
            <button id="btnVerEliminados" class="btn btn-danger mb-3">
                Ver eliminados
            </button>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="row">
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
@if(auth()->check() && in_array(auth()->user()->id_rol, [1,4,8]))
<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-hidden="true">
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
                                @foreach ($tiposMovimiento as $tipo)
                                    <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Descripción larga</label>
                            <textarea name="descripcion_larga" class="form-control" rows="4"
                                placeholder="Ingresa la descripción detallada del producto"></textarea>
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
@if(auth()->check() && in_array(auth()->user()->id_rol, [1,4,8]))
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
                                @foreach ($tiposMovimiento as $tipo)
                                    <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
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
@endif

{{-- JS --}}
@section('js_footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/tienda/stock.js') }}"></script>
@endsection
