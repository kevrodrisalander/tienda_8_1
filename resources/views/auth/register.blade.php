<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #d3d7db;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            padding: 2rem;
            border-radius: 15px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #dc3545;
            font-weight: bold;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-register {
            background-color: #dc3545;
            color: #fff;
            border-radius: 25px;
            width: 100%;
            padding: 0.5rem;
            font-weight: bold;
        }

        .btn-register:hover {
            background-color: #c82333;
        }

        .error-list {
            background-color: #f8d7da;
            color: #842029;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <div class="card">
        <center><img src="{{ asset('icono.png') }}" alt="Logo" width="70" class="mb-2"></center>
        <h2>Crear Cuenta</h2>

        @if ($errors->any())
            <div class="error-list">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-person-fill"></i> Usuario:
                </label>
                <input type="text" name="usuario" class="form-control" value="{{ old('usuario') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-envelope-fill"></i> Correo:
                </label>
                <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="bi bi-lock-fill"></i> Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="bi bi-lock-fill"></i> Confirmar contraseña:</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-register">Registrarse</button>
        </form>

        <p class="text-center mt-3">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-danger fw-bold">Iniciar sesión</a>
        </p>
    </div>

</body>

</html>
