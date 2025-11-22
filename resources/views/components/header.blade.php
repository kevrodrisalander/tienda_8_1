<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/home">Tienda Departamental</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Productos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productosDropdown">
                        {{-- <li><a class="dropdown-item" href="/ropa">Ropa</a></li> --}}
                        {{-- <li><a class="dropdown-item" href="/electronica">Electrónica</a></li> --}}
                        {{-- <li><a class="dropdown-item" href="/hogar">Hogar</a></li> --}}
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="/tiendas">Tiendas</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Administración
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="/administracion">Administración</a></li>
                        {{-- <li><a class="dropdown-item" href="/proveedores">Proveedores</a></li> --}}
                        {{-- <li><a class="dropdown-item" href="/clientes">Clientes</a></li> --}}
                    </ul>
                </li>
            </ul>

            <!-- Botones de acción y carrito -->
            <div class="d-flex align-items-center gap-2">

                @if(Auth::check())
                    <!-- Usuario logueado -->
                    <span class="text-light me-2">
                        {{ Auth::user()->usuario }}
                        ({{ Auth::user()->rolNombre() }})
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
                    </form>
                @else
                    <!-- Usuario no logueado -->
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">Registrarse</a>
                @endif

                <!--Carrito -->
                <button class="btn btn-outline-warning position-relative"
                        data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="bi bi-cart3"></i>
                    <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
                    </span>
                </button>
            </div>
        </div>
    </div>
</nav>
