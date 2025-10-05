@extends('layouts.app')

@section('title', 'Ropa - Tienda Departamental')

@section('content')
    <style>
        .hero-ropa {
            background: url("{{ asset('images/ropa-banner.jpg') }}") no-repeat center center;
            background-size: cover;
            height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
            border-radius: 12px;
            margin-bottom: 40px;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            height: 250px;
            object-fit: cover;
        }

        .btn-outline-primary {
            border-radius: 25px;
            font-weight: bold;
        }
    </style>

    <div class="container">
        <p class="text-center fs-5">Explora lo último en moda: casual, formal y deportiva para toda la familia.</p>
        <br>
        <div class="row mt-4">
            <!-- Producto 1 -->
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ asset('images/ropa/camisa.jpg') }}" class="card-img-top" alt="Camisa Casual">
                    <div class="card-body text-center">
                        <h6 class="card-title">Camisa Casual</h6>
                        <p class="text-muted">$499 MXN</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Añadir al carrito</a>
                    </div>
                </div>
            </div>

            <!-- Producto 2 -->
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ asset('images/ropa/vestido.jpg') }}" class="card-img-top" alt="Vestido Elegante">
                    <div class="card-body text-center">
                        <h6 class="card-title">Vestido Elegante</h6>
                        <p class="text-muted">$899 MXN</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Añadir al carrito</a>
                    </div>
                </div>
            </div>

            <!-- Producto 3 -->
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ asset('images/ropa/sudadera.jpg') }}" class="card-img-top" alt="Sudadera Deportiva">
                    <div class="card-body text-center">
                        <h6 class="card-title">Sudadera Deportiva</h6>
                        <p class="text-muted">$699 MXN</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Añadir al carrito</a>
                    </div>
                </div>
            </div>

            <!-- Producto 4 -->
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ asset('images/ropa/pantalon.jpg') }}" class="card-img-top" alt="Pantalón Formal">
                    <div class="card-body text-center">
                        <h6 class="card-title">Pantalón Formal</h6>
                        <p class="text-muted">$749 MXN</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Añadir al carrito</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
