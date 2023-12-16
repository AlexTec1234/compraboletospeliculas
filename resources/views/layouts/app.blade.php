<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <title>@yield('title', 'Boletos Mx')</title>
   
</head>
<body>
<!-- header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary py-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Boletos CineKaos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                    <a class="nav-link active" href="{{ route('home') }}">Inicio</a>
                    <a class="nav-link active" href="{{ route('carrito.mostrar') }}">Carrito</a>
                @guest
                    <a class="nav-link active" href="{{ route('login') }}">Iniciar sesión</a>
                    <a class="nav-link active" href="{{ route('registro') }}">Registrarse</a>
                @else
                <a class="nav-link active" href="{{ route('editarPerfil') }}">Mi Perfil</a>
                <a class="nav-link active" href="{{ route('compras.completadas') }}">Mis compras</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                         @csrf <!-- Agrega el campo CSRF -->
                         <button type="submit" class="btn btn-secondary">Cerrar Sesión</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
<!-- header -->
    <header class="masthead bg-primary text-white text-center py-4">
        <div class="container d-flex align-items-center flex-column">
            <h2>@yield('subtitle', 'Recomendaciones de Películas 2024')</h2>
        </div>
    </header>
     <!-- Mensajes de error -->
     @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

<!-- header -->
    <div class="container my-4">
        @yield('content')
    </div>

   
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
    
</html>
