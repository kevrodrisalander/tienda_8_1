@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('title', 'Tienda Departamental')

@section('content')
    <div class="container">
        <b><h2 class="text-center my-5">Productos</h2></b>

        <b><p class="text-center">Encuentra todo lo que necesitas en un solo lugar: ropa, electrónica, hogar, belleza y más.</p></b>

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
                                    <th class="text-center">Categoría</th>
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
    <script src="{{ asset('js/tienda/productos.js') }}"></script>
@endsection
