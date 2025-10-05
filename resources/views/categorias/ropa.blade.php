@extends('layouts.app')

@section('title', 'Ropa - Tienda Departamental')

@section('content')
<div class="container">
    <h1 class="mb-4">Colección de Ropa</h1>

    <div class="row">
        @forelse($productos as $producto)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    <img src="{{ asset('imagenes/'.$producto->name_file) }}"
                         class="card-img-top"
                         alt="{{ $producto->descripcion }}"
                         style="height: 200px; object-fit: cover;">

                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold">{{ $producto->descripcion }}</h6>
                        <p class="text-muted mb-1">${{ number_format($producto->precio_venta, 2) }} MXN</p>
                        <p><small>Stock: {{ $producto->stock }}</small></p>

                        <form action="{{ route('cart.add', $producto->id) }}" method="POST">
                            @csrf
                            <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}"
                                   class="form-control mb-2 text-center"
                                   style="width: 80px; margin:auto;">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Añadir al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No hay productos de ropa disponibles en este momento.</p>
        @endforelse
    </div>
</div>
@endsection
