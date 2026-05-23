@extends('layouts.app')

@section('title', 'Música - Tienda Departamental')

@section('content')
    <div class="container">
        <!-- Encabezado visual -->
        <div class="py-4 text-center bg-light rounded mb-4">
            <h1 class="fw-bold">Música</h1>
            <p class="text-muted">Utiliza los mejores productos automotrices</p>
        </div>

        <div class="row">
            @forelse($productos as $producto)
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <img src="{{ asset('storage/' . ($producto->name_file ?? 'default.jpg')) }}" class="card-img-top"
                            alt="{{ $producto->descripcion }}" style="height: 200px; object-fit: cover;">

                        <div class="card-body text-center">
                            <h6 class="card-title fw-bold">{{ $producto->descripcion }}</h6>
                            <p class="text-muted mb-1">${{ number_format($producto->precio_venta, 2) }} MXN</p>
                            <p><small id="stock-{{ $producto->id }}">Stock: {{ $producto->cantidad_stock }}</small></p>

                            <input type="number" id="cantidad-{{ $producto->id }}" value="1" min="1"
                                max="{{ $producto->cantidad_stock }}" class="form-control mb-2 text-center"
                                style="width: 80px; margin:auto;">

                            <!-- Botón para mostrar observaciones -->
                            <button type="button" class="btn btn-info btn-sm w-100 mb-2 btn-observaciones"
                                data-id="{{ $producto->id }}" data-bs-toggle="modal"
                                data-bs-target="#modal-{{ $producto->id }}">
                                <i class="bi bi-info-circle"></i> Descripción
                            </button>

                            <!-- Botón añadir al carrito -->
                            <button class="btn btn-primary btn-sm w-100 btn-add" data-id="{{ $producto->id }}"
                                data-nombre="{{ $producto->descripcion }}" data-precio="{{ $producto->precio_venta }}">
                                <i class="bi bi-cart-plus"></i> Añadir al carrito
                            </button>
                        </div>
                    </div>
                    {{-- Modal observaciones --}}
                    <div class="modal fade modal-producto" id="modal-{{ $producto->id }}" tabindex="-1"
                        aria-labelledby="modalLabel-{{ $producto->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel-{{ $producto->id }}">
                                        Producto: {{ $producto->descripcion }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <b>
                                    <h6>Descripción</h6>
                                </b>
                                <div class="modal-body" id="modal-body-{{ $producto->id }}">
                                    <p class="text-muted">Cargando observaciones...</p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Modal -->

                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No hay productos de frutas y verduras disponibles en este momento.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('js_footer')
    <script src="{{ asset('js/tienda/vistaprod.js') }}"></script>
@endsection