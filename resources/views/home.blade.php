@extends('layouts.app')

@section('title', 'Tienda Departamental')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Bienvenido a Nuestra Tienda Departamental</h2>
<p class="text-center">Encuentra todo lo que necesitas en un solo lugar: ropa, electrónica, hogar, belleza y más.</p>

 <div class="row mt-5">
    @foreach ($categorias as $categoria)
        @include('components.categoria-card', [
            'imagen' => $categoria['imagen'],
            'titulo' => $categoria['titulo'],
            'descripcion' => $categoria['descripcion'],
            'url' => route('categorias.show', $categoria['slug'])
        ])
    @endforeach
