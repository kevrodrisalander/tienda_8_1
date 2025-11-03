@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('title', 'Tienda Departamental')

@section('content')
    <div class="container">
        <b><h2 class="text-center my-5">Provedores</h2></b>

        <b><p class="text-center">Listado de provedores</p></b>

        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="row">
                            <table class="table_id" id="tbl_provedores">
                            <thead>
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th class="text-center">Nombre Marca</th>
                                    <th class="text-center">Provedor</th>
                                    <th class="text-center">Contacto Provedor</th>
                                    <th class="text-center">Telefono</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Dirección</th>
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
    <script src="{{ asset('js/tienda/provedores.js') }}"></script>
@endsection
