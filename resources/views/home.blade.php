@extends('layouts.app')

@section('title', 'Tienda Departamental')

@section('content')
<style>
    .hero-section {
        background: url("{{ asset('images/tienda-banner.jpg') }}") no-repeat center center;
        background-size: cover;
        height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
        border-radius: 12px;
        margin-bottom: 40px;
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .card img {
        height: 220px;
        object-fit: cover;
    }

    .btn-primary {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: bold;
    }
</style>

<div class="container">
      <h1><p class="text-center fs-5">Bienvenido a tu tienda.</p></h1>
    <p class="text-center fs-5">Encuentra todo lo que necesitas en un solo lugar: ropa, electrónica, hogar, belleza y más.</p>

    <div class="row mt-5">
        <!-- Categoría: Ropa -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('imagenes/ropa.jpg') }}" class="card-img-top" alt="Ropa">
                <div class="card-body text-center">
                    <h5 class="card-title">Ropa</h5>
                    <p class="card-text">Moda para toda la familia: casual, formal y deportiva.</p>
                    <a href="ropa" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>

        <!-- Categoría: Electrónica -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('imagenes/electronica.jpg') }}" class="card-img-top" alt="Electrónica">
                <div class="card-body text-center">
                    <h5 class="card-title">Electrónica</h5>
                    <p class="card-text">Celulares, laptops, audífonos y más tecnología.</p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>

        <!-- Categoría: Hogar -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('imagenes/hogar.jpg') }}" class="card-img-top" alt="Hogar">
                <div class="card-body text-center">
                    <h5 class="card-title">Hogar</h5>
                    <p class="card-text">Muebles, decoración, cocina y artículos para tu casa.</p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('imagenes/juguetes.jpg') }}" class="card-img-top" alt="Hogar">
                <div class="card-body text-center">
                    <h5 class="card-title">Juguetes</h5>
                    <p class="card-text">Muebles, decoración, cocina y artículos para tu casa.</p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('imagenes/deportes.jpg') }}" class="card-img-top" alt="Hogar">
                <div class="card-body text-center">
                    <h5 class="card-title">Deportes</h5>
                    <p class="card-text">Muebles, decoración, cocina y artículos para tu casa.</p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
