<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Proyecto')</title>
    <link rel="icon" href="{{ asset('icono.png') }}" type="image/png">

    <!-- Bootstrap CSS primero -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tus estilos personalizados (app.css y tablas.css) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{--
    <link rel="stylesheet" href="{{ asset('css/tablas.css') }}"> --}}
    @vite('resources/css/tablas.css')

    <!-- Librerías JS necesarias en head -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">

    @include('components.header')

    <main class="flex-grow-1 mb-5">
        @yield('content')
    </main>

    @include('components.footer')

    <!-- DataTables y Bootstrap JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modal de carrito -->
    @include('cart.modal')

    <!-- Toast de producto añadido -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="cartToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Producto añadido al carrito ✅
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Cerrar"></button>
            </div>
        </div>
    </div>

    <!-- JS personalizados -->
    <script src="{{ asset('js/tienda/cart.js') }}"></script>
    @yield('js_footer')
</body>

</html>