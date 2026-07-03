<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Repositorio ISTAE</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Theme Switcher Script -->
    <script>
        const getPreferredTheme = () => {
            const storedTheme = localStorage.getItem('theme')
            if (storedTheme) {
                return storedTheme
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        }
        const setTheme = theme => {
            document.documentElement.setAttribute('data-bs-theme', theme)
        }
        setTheme(getPreferredTheme())
        
        window.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('themeToggleBtn')
            if (themeToggle) {
                const updateIcon = () => {
                    const currentTheme = document.documentElement.getAttribute('data-bs-theme')
                    themeToggle.innerHTML = currentTheme === 'dark' ? '<i class="bi bi-sun-fill"></i>' : '<i class="bi bi-moon-stars-fill text-dark"></i>'
                }
                updateIcon()
                themeToggle.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-bs-theme')
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark'
                    localStorage.setItem('theme', newTheme)
                    setTheme(newTheme)
                    updateIcon()
                })
            }
        })
    </script>
    <style>
        .sidebar {
            background-color: var(--primary-blue);
        }
        @media (min-width: 768px) {
            .sidebar {
                min-height: 100vh;
                width: 280px !important;
                position: sticky;
                top: 0;
            }
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

<div class="d-flex flex-column flex-md-row min-vh-100">
    <!-- Mobile Header -->
    <div class="d-md-none text-white p-3 d-flex justify-content-between align-items-center shadow-sm sticky-top" style="background-color: var(--primary-blue);">
        <a href="{{ route('home') }}" class="text-white text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('images/logo.webp') }}" alt="Logo ISTAE" height="32" class="rounded bg-white p-1">
            <span class="fw-bold">RepoISTAE</span>
        </a>
        <button class="btn btn-outline-light border-0 px-2 py-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
            <i class="bi bi-list fs-2"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <div class="offcanvas-md offcanvas-start sidebar text-white" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header d-md-none border-bottom border-secondary">
            <h5 class="offcanvas-title fw-bold" id="sidebarMenuLabel">Menú del Panel</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-3 h-100">
            <a href="{{ route('home') }}" class="d-none d-md-flex align-items-center mb-4 text-white text-decoration-none gap-2 px-2">
                <img src="{{ asset('images/logo.webp') }}" alt="Logo ISTAE" height="40" class="rounded bg-white p-1">
                <span class="fs-5 fw-bold">RepoISTAE</span>
            </a>
            <hr class="border-secondary d-none d-md-block">
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
            <div class="d-flex justify-content-between align-items-center mt-auto pb-2">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle px-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-secondary rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px;">
                            <i class="bi bi-person"></i>
                        </div>
                        <strong>{{ explode(' ', Auth::user()->nombre)[0] }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="{{ route('perfil.index') }}">Mi Perfil</a></li>
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
                <button id="themeToggleBtn" class="btn btn-outline-light border-0 rounded-circle me-1" style="width: 40px; height: 40px;" title="Cambiar tema">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-grow-1 p-3 p-md-4" style="min-width: 0; width: 100%;">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
