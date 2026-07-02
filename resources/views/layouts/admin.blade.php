<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Repositorio ISTAE</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: var(--primary-blue);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            border-radius: 8px;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: var(--white);
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3 text-white" style="width: 280px; position: sticky; top: 0;">
        <a href="{{ route('home') }}" class="d-flex align-items-center mb-4 text-white text-decoration-none gap-2 px-2">
            <i class="bi bi-book-half fs-4 text-danger"></i>
            <span class="fs-5 fw-bold">RepoISTAE</span>
        </a>
        <hr class="border-secondary">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" aria-current="page">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('documentos.index') }}" class="nav-link {{ request()->routeIs('documentos.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text me-2"></i> Documentos
                </a>
            </li>
            @if(in_array(Auth::user()->rol, ['admin', 'bibliotecario']))
            <li>
                <a href="{{ route('admin.comunidades.index') }}" class="nav-link {{ request()->routeIs('admin.comunidades.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3 me-2"></i> Comunidades
                </a>
            </li>
            <li>
                <a href="{{ route('admin.colecciones.index') }}" class="nav-link {{ request()->routeIs('admin.colecciones.*') ? 'active' : '' }}">
                    <i class="bi bi-collection me-2"></i> Colecciones
                </a>
            </li>
            @endif
            @if(Auth::user()->rol === 'admin')
            <li>
                <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Usuarios
                </a>
            </li>
            <li>
                <hr class="border-secondary">
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-gear me-2"></i> Configuración
                </a>
            </li>
            @endif
        </ul>
        <hr class="border-secondary mt-auto" style="margin-top: auto;">
        <div class="dropdown mt-auto pb-3">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle px-2" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-secondary rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px;">
                    <i class="bi bi-person"></i>
                </div>
                <strong>{{ explode(' ', Auth::user()->nombre)[0] }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{ route('home') }}">Ver Portal</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
