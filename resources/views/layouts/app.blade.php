<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mi Proyecto')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
{{-- <body>
        @include('components.header')
    <header>
        <h1>Mi Proyecto Laravel</h1>
        <!-- Puedes incluir navegación aquí -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Mi Proyecto</p>
    </footer>
    @include('components.footer')
</body> --}}
<body class="d-flex flex-column min-vh-100">
    @include('components.header')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('components.footer')
</body>
</html>
