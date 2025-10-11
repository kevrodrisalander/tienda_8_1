@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background-color: #e9e7e7;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        .description {
            font-size: 14px;
            color: #666;
        }

        .boton-verde {
            padding: 8px 16px;
            background-color: #0e6149;
            color: #fff;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .boton-verde:hover {
            background-color: #0c4d3b;
        }
    </style>

    <div class="py-12 px-4 bg-gray-50">
        <h1 style="text-align:center; margin-bottom:40px;" class="text-2xl font-bold text-gray-800">Administración</h1>

        <div class="grid">
            <!-- Desarrollo Web -->
            <div class="card">
                <div class="icon text-4xl mb-2">📋</div>
                <div class="title">Inventario</div>
                <div class="description">
                    Inventario general de la tienda donde se encuentran los registros de los productos que tenemos
                    disponibles
                </div>
                <a href="{{ route('inventario') }}" class="boton-verde">
                    Entrar
                </a>
            </div>

            <!-- Diseño UX/UI -->
            <div class="card">
                <div class="icon text-4xl mb-2">📦</div>
                <div class="title">Stock</div>
                <div class="description">
                    Diseñamos experiencias digitales que no solo se ven increíbles, sino que funcionan al 100% para tus
                    usuarios.
                </div>
                <a href="{{ route('stock') }}" class="boton-verde">
                    Entrar
                </a>
            </div>

            <!-- Comercio Electrónico -->
            <div class="card">
                <div class="icon text-4xl mb-2">👥</div>
                <div class="title">Usuarios</div>
                <div class="description">
                    Creamos herramientas funcionales, atractivas y adaptadas al crecimiento de tus ventas.
                </div>
                <a href="{{ route('usuarios') }}" class="boton-verde">
                    Entrar
                </a>
            </div>

            <div class="card">
                <div class="icon text-4xl mb-2">🏬</div>
                <div class="title">Provedores</div>
                <div class="description">
                    Creamos herramientas funcionales, atractivas y adaptadas al crecimiento de tus ventas.
                </div>
                <a href="{{ route('provedores') }}" class="boton-verde">
                    Entrar
                </a>
            </div>
        </div>
    </div>
@endsection
