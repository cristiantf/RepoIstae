@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container animate-fade-in">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-danger bg-opacity-25 text-white mb-3 px-3 py-2 border border-danger border-opacity-50 rounded-pill">
                    <i class="bi bi-mortarboard-fill me-1"></i> Repositorio Institucional
                </span>
                <h1 class="hero-title">Preservando el conocimiento científico y académico.</h1>
                <p class="hero-subtitle">Accede a tesis, artículos científicos, proyectos y documentos institucionales del Instituto Superior Tecnológico Alberto Enríquez.</p>
                
                <div class="search-box-wrapper animate-fade-in delay-100">
                    <form class="d-flex w-100 mx-auto" action="{{ route('busqueda') }}" method="GET">
                        <div class="input-group input-group-lg shadow-sm">
                            <input type="search" name="q" class="form-control border-0" placeholder="Buscar por título, autor o palabra clave..." aria-label="Buscar">
                            <button class="btn btn-accent-custom px-4" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>
                
                <div class="mt-4 animate-fade-in delay-200">
                    <a href="{{ route('busqueda') }}" class="text-white text-decoration-none me-4 opacity-75 hover-opacity-100"><i class="bi bi-sliders me-1"></i> Búsqueda Avanzada</a>
                    <a href="{{ route('comunidades') }}" class="text-white text-decoration-none opacity-75 hover-opacity-100"><i class="bi bi-collection me-1"></i> Explorar Colecciones</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 border-bottom bg-white">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4 animate-fade-in delay-100">
                <h2 class="display-5 fw-bold text-primary mb-0" style="color: var(--primary-blue) !important;">{{ collect($stats)->get('documentos', 0) }}</h2>
                <p class="text-muted fw-medium text-uppercase tracking-wider">Documentos Publicados</p>
            </div>
            <div class="col-md-4 animate-fade-in delay-200">
                <h2 class="display-5 fw-bold text-primary mb-0" style="color: var(--primary-blue) !important;">{{ collect($stats)->get('comunidades', 0) }}</h2>
                <p class="text-muted fw-medium text-uppercase tracking-wider">Comunidades Activas</p>
            </div>
            <div class="col-md-4 animate-fade-in delay-300">
                <h2 class="display-5 fw-bold text-primary mb-0" style="color: var(--primary-blue) !important;">{{ collect($stats)->get('descargas', 0) ?? 0 }}</h2>
                <p class="text-muted fw-medium text-uppercase tracking-wider">Descargas Totales</p>
            </div>
        </div>
    </div>
</section>

<!-- Communities Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Comunidades del Repositorio</h2>
                <p class="text-muted mb-0">Explora la producción académica organizada por facultades y áreas temáticas.</p>
            </div>
            <a href="{{ route('comunidades') }}" class="btn btn-outline-primary d-none d-md-inline-flex align-items-center gap-2">
                Ver todas <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($comunidades as $comunidad)
            <div class="col-md-6 col-lg-3 animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <a href="{{ route('comunidad.publica', $comunidad->id) }}" class="text-decoration-none">
                    <div class="card-custom p-4 d-flex flex-column h-100">
                        <div class="card-icon-wrapper {{ $loop->index % 2 == 0 ? 'bg-blue-light' : 'bg-red-light' }}">
                            @if($comunidad->nombre == 'Trabajos de Titulación')
                                <i class="bi bi-journal-bookmark-fill"></i>
                            @elseif($comunidad->nombre == 'Artículos Científicos')
                                <i class="bi bi-file-earmark-text-fill"></i>
                            @elseif($comunidad->nombre == 'Proyectos de Investigación')
                                <i class="bi bi-lightbulb-fill"></i>
                            @else
                                <i class="bi bi-building"></i>
                            @endif
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $comunidad->nombre }}</h5>
                        <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($comunidad->descripcion, 80) }}</p>
                        
                        <div class="mt-auto d-flex align-items-center fw-medium small" style="color: var(--primary-blue);">
                            <span>Ver colecciones</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-white border-top">
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3" style="color: var(--primary-blue);">¿Eres estudiante o investigador del ISTAE?</h2>
                <p class="text-muted fs-5 mb-4">Inicia sesión para subir tus trabajos de titulación o artículos de investigación al repositorio institucional. Contribuye al conocimiento abierto.</p>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary-custom px-4 py-2 me-2">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4 py-2">Registrarse</a>
                @else
                    <a href="{{ route('documentos.create') }}" class="btn btn-accent-custom px-4 py-2"><i class="bi bi-cloud-arrow-up me-2"></i> Subir Documento</a>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection
