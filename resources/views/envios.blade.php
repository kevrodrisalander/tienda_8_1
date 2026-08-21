@extends('layouts.app')

@vite('resources/css/tablas.css')

@section('title', 'Envios')

@section('content')
    <div class="container-fluid data-table-page">
        <b>
            <h2 class="text-center my-5">Envios</h2>
        </b>

        <b>
            <p class="text-center">Listado de envios></p>
        </b>
        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    {{-- <div class="row"> --}}
                        <div class="table-responsive">
                            <table class="table_id" id="tbl_envios">
                                <thead>
                                    <tr>
                                        <th>Id Envío</th>
                                        <th>Id Pedido</th>
                                        <th>Fecha Pedido</th>
                                        <th>Fecha Envío</th>
                                        <th>Transportista</th>
                                        <th>Número Guía</th>
                                        <th>Estado Pedido</th>
                                        <th>Estado Envío</th>
                                        <th>Acciones</th>
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
        <script src="{{ asset('js/tienda/envios.js') }}"></script>
    @endsection
