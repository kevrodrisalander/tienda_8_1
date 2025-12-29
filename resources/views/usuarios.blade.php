@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('title', 'Tienda Departamental')

@section('content')
    <div class="container">
        <b><h2 class="text-center my-5">Usuarios</h2></b>

        <b><p class="text-center">Listado de usuarios</p></b>

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
@endsection

@section('js_footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/tienda/usuarios.js') }}"></script>
@endsection
