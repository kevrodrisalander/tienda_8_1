@extends('layouts.app')

@section('title', 'Tienda Departamental')

@section('content')
<style>
    /* Banner principal */
    .hero-section {
        width: 100%;
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

    /* Tarjetas de categoría */
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

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 0.95rem;
        color: #555;
    }

    .btn-primary {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: bold;
        background-color: #054991;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Responsive ajustes */
    @media (max-width: 768px) {
        .card img {
            height: 180px;
        }
    }
</style>

<div class="container">
   <p class="text-center fs-5">Encuentra todo lo que necesitas en un solo lugar: ropa, electrónica, hogar, belleza y más.</p>

    <div class="row mt-5">
        @foreach($secciones as $seccion)
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('imagenes/' . strtolower($seccion->nombre) . '.jpg') }}" class="card-img-top" alt="{{ $seccion->nombre }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $seccion->nombre }}</h5>
                        <p class="card-text">{{ $seccion->descripcion ?? 'Explora esta categoría.' }}</p>
                        <a href="{{ route('categoria.mostrar', ['slug' => $seccion->slug]) }}" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
