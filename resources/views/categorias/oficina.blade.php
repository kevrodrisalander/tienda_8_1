@extends('layouts.app')

@section('title', 'Oficina - Tienda Departamental')

@section('content')
<div class="container">
    <!-- Encabezado visual -->
    <div class="py-4 text-center bg-light rounded mb-4">
        <h1 class="fw-bold">Colección de productos de oficina</h1>
        <p class="text-muted">Explora nuestra selección de productos de oficina para tu espacio de trabajo</p>
    </div>

    <div class="row">
        @forelse($productos as $producto)
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    {{-- <img src="{{ asset('imagenes/' . ($producto->name_file ?? 'default.jpg')) }}" --}}
                    <img src="{{ asset('storage/' . ($producto->name_file ?? 'default.jpg')) }}"
                         class="card-img-top"
                         alt="{{ $producto->descripcion }}"
                         style="height: 200px; object-fit: cover;">

                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold">{{ $producto->descripcion }}</h6>
                        <p class="text-muted mb-1">${{ number_format($producto->precio_venta, 2) }} MXN</p>
                        <p><small>Stock: {{ $producto->stock }}</small></p>

                        {{-- Input cantidad y botón JS --}}
                        <input type="number" id="cantidad-{{ $producto->id }}" value="1" min="1" max="{{ $producto->stock }}"
                               class="form-control mb-2 text-center"
                               style="width: 80px; margin:auto;">
                        <button class="btn btn-primary btn-sm w-100 btn-add"
                                data-id="{{ $producto->id }}"
                                data-nombre="{{ $producto->descripcion }}"
                                data-precio="{{ $producto->precio_venta }}">
                            <i class="bi bi-cart-plus"></i> Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No hay productos de oficina disponibles en este momento.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
