@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('title', 'Tienda Departamental')

@section('content')
    <div class="container">
        <b>
            <h2 class="text-center my-5">Usuarios</h2>
        </b>

        <b>
            <p class="text-center">Listado de usuarios</p>
        </b>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
            Agregar usuario
        </button>

        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalFiltrosUsuarios">
            Filtros
        </button>

        <button id="btnVerUsuariosEliminados" class="btn btn-danger mb-3">
            Ver eliminados
        </button>

        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="row">
                        <table class="table_id" id="tbl_usuarios">
                            <thead>
                                <tr>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Correo</th>
                                    <th class="text-center">Id Rol</th>
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">Descripción rol</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Editar Usuario --}}
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- Cabecera del Modal --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                {{-- Cuerpo del Modal --}}
                <div class="modal-body">
                    <form id="formEditarUsuario" method="POST">
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        {{-- ID oculto del usuario --}}
                        <input type="hidden" name="id_usuario" id="usuarioId">

                        {{-- Nombre de usuario --}}
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>

                        {{-- Correo --}}
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>

                        {{-- Selección de rol --}}
                        <div class="mb-3">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select class="form-select" id="id_rol" name="id_rol" required>
                                <option value="">Selecciona un rol</option>
                                {{-- Los roles se cargarán dinámicamente --}}
                            </select>
                        </div>

                        {{-- Botón guardar --}}
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>

                {{-- Pie del Modal --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Fin Modal Editar Usuario --}}
@endsection

@section('js_footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/tienda/usuarios.js') }}"></script>
@endsection
