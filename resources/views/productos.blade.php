@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('title', 'Tienda Departamental')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Productos</h2>

    <p class="text-center">Encuentra todo lo que necesitas en un solo lugar: ropa, electrónica, hogar, belleza y más.</p>

    <div class="row">
                <div class="col-lg-12 col-lg-12">
                    <br>
                    <div class="check-out-box">
                        {{-- {{ csrf_field() }} --}}
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="row">
                            {{-- <table class="table_id" id="tbl_productos"
                                style="background-color: #f5f5f5; color: #110f10;">
                                <thead>
                                    <tr style="background-color: #7a221f; color: #ffffff;">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">descripción</th>
                                        <th class="text-center">stock</th>
                                        <th class="text-center">precio de venta</th>
                                        <th class="text-center">status</th>
                                        <th class="text-center">categoria</th>
                                        {{-- <th class="text-center">Localidad</th> --}}
                                        {{-- <th class="text-center">Datos de Contacto</th> --}}
                                        {{-- <th class="text-center">Acciones</th> --}}
                                    {{-- </tr>
                                </thead>
                            </table> --}}

                            <table class="table_id" id="tbl_productos">
    <thead>
        <tr>
            <th class="text-center">Id</th>
            <th class="text-center">Descripción</th>
            <th class="text-center">Stock</th>
            <th class="text-center">Precio de venta</th>
            <th class="text-center">Status</th>
            <th class="text-center">Categoría</th>
            {{-- <th class="text-center">Localidad</th> --}}
            {{-- <th class="text-center">Datos de Contacto</th> --}}
            {{-- <th class="text-center">Acciones</th> --}}
        </tr>
    </thead>
</table>
                            <!-- Aquí va el script que declara usuarioRol -->
                            {{-- Se verifica que tipo de usuario es --}}
                            {{-- <script>
                                const usuarioRol = @json(auth()->user()->rol);
                            </script> --}}
                        </div>
                    </div>
                </div>
            </div>

    </div>
@endsection
