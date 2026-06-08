@extends('layouts.app')

{{--
<link rel="stylesheet" href="{{ asset('css/tablas.css') }}"> --}}
@vite('resources/css/tablas.css')

@section('title', 'Usuarios')

@section('content')
    <div class="container">
        <b>
            <h2 class="text-center my-5">Usuarios</h2>
        </b>

        <b>
            <p class="text-center">Listado de usuarios</p>
        </b>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
            <i class="bi bi-plus-circle me-2"></i>Agregar usuario
        </button>

        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalFiltrosUsuarios">
            <i class="bi bi-funnel"></i>Filtros
        </button>

        <button id="btnVerUsuariosEliminados" class="btn btn-danger mb-3">
            <i class="bi bi-file-earmark-x"></i>Ver eliminados
        </button>

        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    {{-- <div class="row"> --}}
                        <div class="table-responsive">
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
        <div class="modal fade modal-producto" id="modalEditarUsuario" tabindex="-1"
            aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
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


        {{-- Modal Filtros Usuarios --}}
        <div class="modal fade modal-producto" id="modalFiltrosUsuarios" tabindex="-1"
            aria-labelledby="modalFiltrosUsuariosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    {{-- Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFiltrosUsuariosLabel">
                            Filtros de Usuarios
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body">
                        <form id="formFiltrosUsuarios">

                            <div class="row">
                                {{-- Usuario --}}
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_usuario" class="form-label">
                                        <i class="bi bi-person"></i> Usuario
                                    </label>
                                    <input type="text" class="form-control" id="filtro_usuario" name="usuario"
                                        placeholder="Buscar por usuario">
                                </div>

                                {{-- Correo --}}
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_correo" class="form-label">
                                        <i class="bi bi-envelope"></i> Correo
                                    </label>
                                    <input type="text" class="form-control" id="filtro_correo" name="correo"
                                        placeholder="Buscar por correo">
                                </div>
                            </div>

                            <div class="row">
                                {{-- Rol con búsqueda --}}
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_rol" class="form-label">
                                        <i class="bi bi-person-rolodex"></i> Rol
                                    </label>
                                    <select class="form-select" id="filtro_rol" name="rol" style="width: 100%">
                                        <option value="">Todos los roles</option>
                                    </select>
                                </div>

                                {{-- Estado --}}
                                <div class="col-md-6 mb-3">
                                    <label for="filtro_estado" class="form-label">
                                        Estado
                                    </label>
                                    <select class="form-select" id="filtro_estado" disabled>
                                        <option value="">Activos</option>
                                        <option value="1">Eliminados</option>
                                    </select>
                                    <small class="text-muted">
                                        El estado se controla con el botón
                                        <b>"Ver eliminados"</b>
                                    </small>
                                </div>
                            </div>

                        </form>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnLimpiarFiltros">
                            Limpiar
                        </button>

                        <button type="button" class="btn btn-primary" id="btnAplicarFiltros">
                            Aplicar filtros
                        </button>
                    </div>

                </div>
            </div>
        </div>
        {{-- Fin Modal Filtros Usuarios --}}

        {{-- Modal Nuevo Usuario --}}
        <div class="modal fade modal-producto" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoUsuarioLabel"
            aria-hidden="true">

            <div class="modal-dialog">
                <div class="modal-content">

                    {{-- Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNuevoUsuarioLabel">
                            Nuevo Usuario
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body">
                        <form id="formNuevoUsuario" method="POST">
                            @csrf

                            {{-- Usuario --}}
                            <div class="mb-3">
                                <label for="nuevo_usuario" class="form-label">
                                    <i class="bi bi-person-circle"></i> Usuario
                                </label>
                                <input type="text" class="form-control" id="nuevo_usuario" name="usuario" required>
                            </div>

                            {{-- Correo --}}
                            <div class="mb-3">
                                <label for="nuevo_correo" class="form-label">
                                    <i class="bi bi-envelope"></i> Correo
                                </label>
                                <input type="email" class="form-control" id="nuevo_correo" name="correo" required>
                            </div>

                            {{-- Rol --}}
                            <div class="mb-3">
                                <label for="nuevo_id_rol" class="form-label">
                                    <i class="bi bi-person-rolodex"></i>Rol
                                </label>
                                <select class="form-select" id="nuevo_id_rol" name="id_rol" required>
                                    <option value="">Selecciona un rol</option>
                                    {{-- Se carga dinámicamente --}}
                                </select>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="nuevo_password" class="form-label">
                                    <i class="bi bi-file-earmark-lock"></i> Contraseña
                                </label>
                                <input type="password" class="form-control" id="nuevo_password" name="password" required>
                            </div>

                            {{-- Confirmar Password --}}
                            <div class="mb-3">
                                <label for="nuevo_password_confirmation" class="form-label">
                                    <i class="bi bi-file-earmark-lock"></i> Confirmar Contraseña
                                </label>
                                <input type="password" class="form-control" id="nuevo_password_confirmation"
                                    name="password_confirmation" required>
                            </div>

                            {{-- Botón guardar --}}
                            <button type="submit" class="btn btn-primary w-100">
                                Guardar Usuario
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        {{-- Fin Modal Nuevo Usuario --}}



@endsection

    @section('js_footer')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/tienda/usuarios.js') }}"></script>
    @endsection