@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('title', 'Tienda Departamental')

@section('content')
    <div class="container">
        <b>
            <h2 class="text-center my-5">Inventario</h2>
        </b>

        <b>
            <p class="text-center">Listado de los productos que se encuentran registrados en la tienda</p>
        </b>

        <div class="row">
            <div class="col-lg-12">
                <br>
                <div class="check-out-box">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="row">
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
                                    <th class="text-center">id sec</th>
                                    <th class="text-center">Categoría sec</th>
                                    <th class="text-center">Vista</th>
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
    <script src="{{ asset('js/tienda/inventario.js') }}"></script>
@endsection
