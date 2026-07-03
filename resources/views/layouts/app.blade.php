<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inicio') - Repositorio Digital ISTAE</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Repositorio Digital Institucional del Instituto Superior Tecnológico Alberto Enríquez.">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <i class="bi bi-book-half text-danger"></i>
                <div>Repo<span>ISTAE</span></div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex ms-lg-3" role="search" action="{{ route('busqueda') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control border-secondary text-white bg-transparent" type="search" name="q" placeholder="Buscar repositorio..." aria-label="Search" value="{{ request('q') }}">
                        <button class="btn btn-outline-light border-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Comunidades</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="nav-link fw-semibold">Ingresar</a>
                        <a href="{{ route('register') }}" class="btn btn-accent-custom">Registrarse</a>
                    @else
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="bg-blue-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                {{ explode(' ', Auth::user()->nombre)[0] }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                @if(in_array(Auth::user()->rol, ['admin', 'bibliotecario']))
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item" href="#"><i class="bi bi-folder me-2"></i>Mis Documentos</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-book-half fs-4 text-danger"></i>
                        <h4 class="text-white mb-0">RepoISTAE</h4>
                    </div>
                    <p class="text-white-50">El Repositorio Digital Institucional del Instituto Superior Tecnológico Alberto Enríquez preserva, difunde y proporciona acceso a la producción académica y científica de nuestra institución.</p>
                </div>
                <div class="col-lg-2 offset-lg-2">
                    <h5 class="text-white mb-3">Enlaces</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="#">Comunidades</a></li>
                        <li><a href="#">Acerca del Repositorio</a></li>
                        <li><a href="#">Políticas de Uso</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-3">Contacto</h5>
                    <ul class="list-unstyled text-white-50 d-flex flex-column gap-2">
                        <li><i class="bi bi-geo-alt me-2"></i> Atuntaqui, Imbabura - Ecuador</li>
                        <li><i class="bi bi-envelope me-2"></i> repositorio@istae.edu.ec</li>
                        <li><i class="bi bi-globe me-2"></i> <a href="https://www.istae.edu.ec" target="_blank">www.istae.edu.ec</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center text-white-50">
                <small>&copy; {{ date('Y') }} Instituto Superior Tecnológico Alberto Enríquez. Todos los derechos reservados.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
