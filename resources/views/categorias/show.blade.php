@extends('layouts.app')

@php
    $nombreCategoria = Illuminate\Support\Str::headline($categoria->slug);
@endphp

@section('title', $nombreCategoria . ' - Tienda Departamental')

@section('content')
    <div class="container">
        <div class="py-4 text-center bg-light rounded mb-4">
            <h1 class="fw-bold">{{ $nombreCategoria }}</h1>
            <p class="text-muted">{{ $categoria->descripcion ?? 'Explora nuestra selección de productos.' }}</p>
        </div>

        <div class="row">
            @forelse ($productos as $producto)
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <img
                            src="{{ asset('storage/' . ($producto->name_file ?? 'default.jpg')) }}"
                            class="card-img-top"
                            alt="{{ $producto->descripcion }}"
                            style="height: 200px; object-fit: cover;"
                        >

                        <div class="card-body text-center">
                            <h6 class="card-title fw-bold">{{ $producto->descripcion }}</h6>
                            <p class="text-muted mb-1">${{ number_format($producto->precio_venta, 2) }} MXN</p>
                            <p>
                                <small id="stock-{{ $producto->id }}">
                                    Stock: {{ $producto->cantidad_stock }}
                                </small>
                            </p>

                            <input
                                type="number"
                                id="cantidad-{{ $producto->id }}"
                                value="1"
                                min="1"
                                max="{{ $producto->cantidad_stock }}"
                                class="form-control mb-2 text-center"
                                style="width: 80px; margin: auto;"
                            >

                            <button
                                type="button"
                                class="btn btn-info btn-sm w-100 mb-2 btn-observaciones"
                                data-id="{{ $producto->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-{{ $producto->id }}"
                            >
                                <i class="bi bi-info-circle"></i> Descripción
                            </button>

                            <button
                                type="button"
                                class="btn btn-primary btn-sm w-100 btn-add"
                                data-id="{{ $producto->id }}"
                                data-nombre="{{ $producto->descripcion }}"
                                data-precio="{{ $producto->precio_venta }}"
                            >
                                <i class="bi bi-cart-plus"></i> Añadir al carrito
                            </button>
                        </div>
                    </div>

                    <div
                        class="modal fade modal-producto"
                        id="modal-{{ $producto->id }}"
                        tabindex="-1"
                        aria-labelledby="modalLabel-{{ $producto->id }}"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel-{{ $producto->id }}">
                                        Producto: {{ $producto->descripcion }}
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Cerrar"
                                    ></button>
                                </div>

                                <div class="modal-body" id="modal-body-{{ $producto->id }}">
                                    <h6 class="fw-bold">Descripción</h6>
                                    <p class="text-muted">Cargando observaciones...</p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">
                        No hay productos disponibles en esta categoría.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('js_footer')
    <script src="{{ asset('js/tienda/vistaprod.js') }}"></script>
@endsection
