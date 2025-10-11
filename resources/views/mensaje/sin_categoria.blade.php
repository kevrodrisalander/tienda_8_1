@extends('layouts.app')

@section('title', 'Categoría no disponible')

@section('content')
<div class="max-w-xl mx-auto text-center py-16 px-4">
    <h1 class="text-5xl font-bold text-red-600 mb-6">¡Ups! 😕</h1>
    <p class="text-xl text-gray-800">
        La categoría <span class="text-blue-600 font-semibold">{{ $slug }}</span> no tiene una vista disponible.
    </p>
    <p class="mt-4 text-gray-500">
        Es posible que esté en construcción, haya sido removida o que el enlace sea incorrecto.
    </p>

    {{-- Botón para regresar al home --}}
   <a href="{{ route('home') }}"
   class="inline-block border border-blue-600 text-blue-600 px-4 py-2 rounded hover:bg-blue-600 hover:text-green transition">
    Volver al inicio
</a>
</div>
@endsection
