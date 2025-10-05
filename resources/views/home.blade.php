@extends('layouts.app')

@section('title', 'Tienda Departamental')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Bienvenido a Nuestra Tienda Departamental</h2>

    <p class="text-center">Encuentra todo lo que necesitas en un solo lugar: ropa, electrónica, hogar, belleza y más.</p>

    <div class="row mt-5">
        <!-- Categoría: Ropa -->
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('images/ropa.jpg') }}" class="card-img-top" alt="Ropa">
                <div class="card-body">
                    <h5 class="card-title">Ropa</h5>
                    <p class="card-text">Moda para toda la familia: casual, formal y deportiva.</p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>

        <!-- Categoría: Electrónica -->
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('images/electronica.jpg') }}" class="card-img-top" alt="Electrónica">
                <div class="card-body">
                    <h5 class="card-title">Electrónica</h5>
                    <p class="card-text">Celulares, laptops, audífonos y más tecnología.</p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>

        <!-- Categoría: Hogar -->
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('images/hogar.jpg') }}" class="card-img-top" alt="Hogar">
                <div class="card-body">
                    <h5 class="card-title">Hogar</h5>
                    <p class="card-text">Muebles, decoración, cocina y artículos para tu casa.</p>
                    <a href="#" class="btn btn-primary">Ver más</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
