@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('title', 'Tienda Departamental')

@section('content')
    <div class="container">
        <b>
            <h1 class="text-center my-5">Stock</h1>
        </b>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
    Agregar producto
</button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFiltros">
    Filtros
</button>


        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                    <th class="text-center">Observaciones</th>
                                    <th class="text-center">Tipo movimiento</th>
                                    <th class="text-center">Acciones</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



{{-- Modal de registrar producto  --}}
<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-labelledby="modalNuevoProductoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('producto.guardar') }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoProductoLabel">Registrar nuevo producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Nombre del producto -->
                        <div class="col-md-6">
                            <label for="nombre_producto" class="form-label">Nombre del producto</label>
                            <input type="text" name="nombre_producto" id="nombre_producto" class="form-control"
                                required>
                        </div>

                        <!-- Cantidad inicial -->
                        <div class="col-md-3">
                            <label for="cantidad_inicial" class="form-label">Cantidad inicial</label>
                            <input type="number" name="cantidad_inicial" id="cantidad_inicial" class="form-control"
                                required>
                        </div>

                        <!-- Precio de venta -->
                        <div class="col-md-3">
                            <label for="precio_venta" class="form-label">Precio de venta</label>
                            <input type="number" name="precio_venta" id="precio_venta" class="form-control" required>
                        </div>
                        <!-- Cantidad mínima -->
                        <div class="col-md-4">
                            <label for="cantidad_minima" class="form-label">Cantidad mínima</label>
                            <input type="number" name="cantidad_minima" id="cantidad_minima" class="form-control"
                                required>
                            Cantidad maxima
                        </div>
                        <div class="col-md-4">
                            <label for="stock" class="form-label">Cantidad maxima</label>
                            <input type="number" name="cantidad_maxima" id="cantidad_maxima" class="form-control"
                                required>
                        </div>
                        <!-- Estatus -->
                        <div class="col-md-4">
                            <label for="cantidad" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="">Selecciona estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Marca -->
                        <div class="col-md-6">
                            <label for="id_marca" class="form-label">Marca</label>
                            <select name="id_marca" id="id_marca" class="form-select" required>
                                <option value="">Selecciona una marca</option>
                                @foreach ($marcas as $marca)
                                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Categoría -->
                        <div class="col-md-6">
                            <label for="id_categoria" class="form-label">Categoría</label>
                            <select name="id_categoria" id="id_categoria" class="form-select" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nuevo_lote" class="form-label">Lote</label>
                            <input type="text" name="nuevo_lote" id="nuevo_lote" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Tipo movimiento</label>
                            <select name="tipo_movimiento" id="tipo_movimiento" class="form-select" required>
                                <option value="">Selecciona tipo</option>
                                @foreach ($tiposMovimiento as $tipo)
                                    <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fechaIngreso" class="form-label">Fecha de ingreso</label>
                            <input type="date" name="fecha_ingreso" id="fechaIngreso" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="fechaVencimiento" class="form-label">Fecha de vencimiento</label>
                            <input type="date" name="fecha_vencimiento" id="fechaVencimiento"
                                class="form-control" required>
                        </div>
                        <!-- Observaciones -->
                        <div class="col-md-6">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <input type="text" name="observaciones" id="observaciones" class="form-control"
                                required>
                        </div>

                    </div>
                </div>

                <!-- Botones -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Fin de modal para registrar  --}}

{{-- Modal de actualizar producto --}}
<div class="modal fade" id="modalSimple" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Actualizar stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="cantidad" class="form-label">Selecciona una sección</label>
                            <select name="producto_id" id="producto_id" class="form-select" required>
                                <option value="">Selecciona una sección</option>
                                {{-- @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->descripcion }}</option>
                            @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="cantidad" class="form-label">Selecciona un producto</label>
                            <select name="producto_id" id="producto_id" class="form-select" required>
                                <option value="">Selecciona un producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad">
                        </div>
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion">
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Tipo estado</label>
                            <select name="estado" id="estado" class="form-select" required>
                                <option value="">Selecciona estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Selecciona un lote</label>
                            <select name="id_lote" id="id_lote" class="form-select" required>
                                <option value="">Selecciona un lote</option>
                                @foreach ($lotes as $lote)
                                    <option value="{{ $lote->id_lote }}">{{ $lote->codigo_lote }} -
                                        {{ $lote->descripcion ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="maximos" class="form-label">Máximos</label>
                            <input type="number" class="form-control" id="maximos">
                        </div>
                        <div class="col-md-6">
                            <label for="minimos" class="form-label">Mínimos</label>
                            <input type="number" class="form-control" id="minimos">
                        </div>

                        <!-- Fechas -->
                        <div class="col-md-6">
                            <label for="fechaIngreso" class="form-label">Fecha de ingreso</label>
                            <input type="date" class="form-control" id="fechaIngreso">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaVencimiento" class="form-label">Fecha de vencimiento</label>
                            <input type="date" class="form-control" id="fechaVencimiento">
                        </div>
                        <!-- Tipo de movimiento -->
                        <label for="cantidad" class="form-label">Tipo de entrada</label>
                        <select name="tipo_movimiento" id="tipo_movimiento" class="form-select" required>
                            <option value="">Selecciona tipo</option>
                            @foreach ($tiposMovimiento as $tipo)
                                <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                            @endforeach
                        </select>
                        <div class="col-md-12">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <input type="text" class="form-control" id="observaciones">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{-- Fin modal para modificar --}}

<!-- SweetAlert2 CDN (si no lo tienes en tu layout) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Mostrar mensaje si hay success o error -->
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@section('js_footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/tienda/stock.js') }}"></script>
@endsection
