<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/home">Tienda Departamental</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- Menú Productos: disponible para todos los usuarios logueados --}}
                @if(Auth::check())

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Productos
                        </a>

                        <div class="dropdown-menu p-3" aria-labelledby="productosDropdown" style="min-width: 600px;">
                            <div class="row">

                                <!-- Columna 1 -->
                                <div class="col-md-4">
                                    <h6 class="dropdown-header">Alimentos</h6>
                                    <a class="dropdown-item" href="/categoria/frutas">Frutas 🍐</a>
                                    <a class="dropdown-item" href="/categoria/verduras">Verduras 🥗</a>
                                    <a class="dropdown-item" href="/categoria/panaderia">Panadería 🍞</a>

                                    <h6 class="dropdown-header mt-3">Hogar</h6>
                                    <a class="dropdown-item" href="/categoria/hogar">Hogar 🏠</a>
                                    <a class="dropdown-item" href="/categoria/oficina">Oficina 🏢</a>
                                </div>

                                <!-- Columna 2 -->
                                <div class="col-md-4">
                                    <h6 class="dropdown-header">Tecnología</h6>
                                    <a class="dropdown-item" href="/categoria/electronica">Electrónica 💻</a>
                                    <a class="dropdown-item" href="/categoria/videojuegos">Videojuegos 🎮 </a>

                                    <h6 class="dropdown-header mt-3">Moda</h6>
                                    <a class="dropdown-item" href="/categoria/ropa">Ropa 🥼</a>
                                    <a class="dropdown-item" href="/categoria/accesorios">Accesorios 👜</a>
                                    <a class="dropdown-item" href="/categoria/belleza">Belleza 💄</a>
                                </div>

                                <!-- Columna 3 -->
                                <div class="col-md-4">
                                    <h6 class="dropdown-header">Otros</h6>
                                    <a class="dropdown-item" href="/categoria/deportes">Deportes ⛷️</a>
                                    <a class="dropdown-item" href="/categoria/juguetes">Juguetes 🏎️</a>
                                    <a class="dropdown-item" href="/categoria/libros">Libros 📚</a>
                                    <a class="dropdown-item" href="/categoria/mascotas">Mascotas 🐱</a>
                                    <a class="dropdown-item" href="/categoria/musica">Música 🎵</a>
                                    <a class="dropdown-item" href="/categoria/salud">Salud 🧑‍⚕️</a>
                                    <a class="dropdown-item" href="/categoria/automotriz">Automotriz 🏎️</a>
                                </div>

                            </div>
                        </div>
                    </li>
                @endif

                {{-- Menú Tiendas: solo para Administrador (rol=1) --}}
                @if(Auth::check() && Auth::user()->id_rol == 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tiendasDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Tiendas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="tiendasDropdown">
                            <li>
                                <a class="dropdown-item" href="/tiendas">
                                    Tiendas <i class="fa-solid fa-building"></i>
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif

                {{-- Menú Administración: solo para roles específicos --}}
                @if(Auth::check() && in_array(Auth::user()->id_rol, [1, 2, 9]))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Administración
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="/administracion">Administración <i
                                        class="fa-solid fa-clipboard-user"></i></a></li>
                            <li><a class="dropdown-item" href="/reportes/reportes">Reportes <i
                                        class="fa-solid fa-file"></i></a></li>
                        </ul>
                    </li>
                @endif

            </ul>

            <!-- Botones de acción y carrito -->
            <div class="d-flex align-items-center gap-2">

                @if(Auth::check())
                    {{-- Usuario logueado --}}
                    <span class="text-light me-3">
                        {{ Auth::user()->usuario }}
                        ({{ Auth::user()->rolNombre() }})
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
                    </form>
                @else
                    {{-- Usuario no logueado --}}
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Iniciar sesión <i
                            class="fa-solid fa-user"></i></a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">Registrarse <i
                            class="fa-solid fa-user"></i></a>
                @endif

                <!--Carrito -->
                <button class="btn btn-outline-warning position-relative" data-bs-toggle="modal"
                    data-bs-target="#cartModal">
                    <i class="bi bi-cart3"></i>
                    <span id="cartCount"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
                    </span>
                </button>
            </div>
        </div>
    </div>
</nav>