@extends('layouts.app')
@vite('resources/css/tablas.css')
@section('title', 'Clientes')
@section('content')

    <div class="container">
        <h2 class="text-center my-4">Clientes</h2>
        <p class="text-center">
            Listado de clientes
        </p>

        <div class="d-flex gap-2 mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFiltrosClientes">
                <i class="fas fa-filter"></i> Filtros
            </button>

            @if(auth()->check() && in_array(auth()->user()->id_rol, [1, 4]))
                <button id="btnVerEliminados" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Ver eliminados
                </button>
            @endif

        </div>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="table-responsive">
            <table id="tbl_clientes" class="table_id">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Fecha registro</th>
                        <th>ID Usuario</th>
                        <th>Observaciones</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal Editar Cliente --}}
    <div class="modal fade modal-producto" id="modalEditarCliente" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditarCliente">
                    @csrf
                    <input type="hidden" id="edit_id_cliente" name="id_cliente">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="edit_telefono" name="telefono">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <textarea class="form-control" id="edit_direccion" name="direccion" rows="3"></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="edit_activo" name="activo">
                            <label class="form-check-label" for="edit_activo">Cliente activo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Modal Filtros --}}
    <div class="modal fade modal-producto" id="modalFiltrosClientes" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filtrar clientes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" id="filtroNombre" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="text" id="filtroCorreo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" id="filtroTelefono" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnAplicarFiltros" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/tienda/clientes.js') }}"></script>
@endsection