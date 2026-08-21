@extends('layouts.app')

{{--
<link rel="stylesheet" href="{{ asset('css/tablas.css') }}"> --}}
@vite('resources/css/tablas.css')

@section('title', 'Inventario')

@section('content')
    <div class="container-fluid data-table-page">
        <b>
            <h2 class="text-center my-5">Inventario</h2>
        </b>

        <b>
            <p class="text-center">Listado de los productos que se encuentran registrados en la tienda</p>
        </b>

        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalFiltrosInventario">
            Filtros
        </button>

        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    {{-- <div class="row"> --}}
                        <div class="table-responsive">
                            <table class="table_id" id="tbl_productos">
                                <thead>
                                    <tr>
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Precio de venta</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Id Marca</th>
                                        <th class="text-center">Marca</th>
                                        <th class="text-center">Categoría</th>
                                        <th class="text-center">Detallles</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade modal-producto" id="modalDetallesProducto" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p><strong>Producto:</strong> <span id="modalProducto"></span></p>
                        <hr>
                        {{-- <p id="modalDetalles"></p> --}}
                        <p><strong>Detalles:</strong> <span id="modalDetalles"></span></p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal Filtros Inventario --}}
        <div class="modal fade modal-producto" id="modalFiltrosInventario" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Filtros de inventario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            {{-- Descripción --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Descripción</label>
                                <input type="text" id="filtro_descripcion" class="form-control"
                                    placeholder="Buscar por descripción">
                            </div>


                            {{-- Marca --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Marca</label>
                                <select id="filtro_marca" class="form-control select2">
                                    <option value="">Todas</option>
                                </select>
                            </div>

                            {{-- Categoría --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Categoría</label>
                                <select id="filtro_categoria" class="form-control select2">
                                    <option value="">Todas</option>
                                </select>
                            </div>

                            {{-- Estatus --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estatus</label>
                                <select id="filtro_status" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            {{-- Stock --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock</label>
                                <select id="filtro_stock" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="con">Con stock</option>
                                    <option value="sin">Sin stock</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="btnAplicarFiltros">
                            Aplicar filtros
                        </button>
                    </div>

                </div>
            </div>
        </div>

@endsection

    @section('js_footer')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/tienda/inventario.js') }}"></script>
    @endsection
