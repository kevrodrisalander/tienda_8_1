@extends('layouts.sinheader')

@section('title', 'Iniciar Sesión')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="max-width: 420px; width: 100%; border-radius: 15px;">

        <div class="text-center mb-4">
            <img src="{{ asset('icono.png') }}" alt="Logo" width="70" class="mb-2">
            <h3 class="fw-bold text-danger">Iniciar Sesión</h3>
        </div>

        {{-- Mensaje de error --}}
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            {{-- Contraseña --}}
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            {{-- Recordar --}}
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Recordarme</label>
            </div>

            {{-- Botón --}}
            <button type="submit" class="btn btn-danger w-100 fw-bold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
            </button>
        </form>

        <div class="text-center mt-3">
            <p class="m-0">¿No tienes cuenta?
                {{-- <a href="{{ route('register') }}" class="text-decoration-none">Registrarse</a> --}}
            </p>
        </div>

    </div>
</div>

@endsection
