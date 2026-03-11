@extends('layouts.app')
@vite('resources/css/tablas.css')
@section('title', 'Stock')

@section('content')
    <div class="container">
        <b>
            <h2 class="text-center my-5">Clientes</h2>
        </b>

        <b>
            <p class="text-center">Listado del clientes</p>
        </b>


        {{-- Botón Filtros visible para todos --}}
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalcliente">
            Filtros
        </button>

        {{-- Ver eliminados solo para roles permitidos --}}
        @if(auth()->check() && in_array(auth()->user()->id_rol, [1, 4]))
            <button id="btnVerEliminados" class="btn btn-danger mb-3">
                Ver eliminados
            </button>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="row">
                        <table class="table_id" id="tbl_clientes">
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre de clientes</th>
                                    <th class="text-center">Correo</th>
                                    <th class="text-center">Telefono</th>
                                    <th class="text-center">Dirección</th>
                                    <th class="text-center">Fecha registro</th>
                                    <th class="text-center">id usuario</th>
                                    <th class="text-center">Observaciones</th>
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

{{-- Modal editar stock solo para roles permitidos --}}
@if(auth()->check() && in_array(auth()->user()->id_rol, [1, 4, 8]))
    <div class="modal fade modal-producto" id="modalcliente" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditarStock" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Filtrar clientes</h5>
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

                            {{-- <div class="col-md-6">
                                <label class="form-label">Tipo movimiento</label>
                                <select name="tipo_movimiento" class="form-select">
                                    @foreach ($tiposMovimiento as $tipo)
                                        <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

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
    <script src="{{ asset('js/tienda/clientes.js') }}"></script>
@endsection
