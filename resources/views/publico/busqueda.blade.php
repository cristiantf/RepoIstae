@extends('layouts.app')
@section('title', 'Buscador Global')
@section('content')

<div class="bg-light py-4 border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold text-primary-custom mb-1">
                    @if(request('q'))
                        Resultados para: "{{ request('q') }}"
                    @else
                        Explorar Repositorio
                    @endif
                </h2>
                <p class="text-muted mb-0">Se encontraron {{ $documentos->total() }} documentos</p>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <form action="{{ route('busqueda') }}" method="GET">
                    @foreach(request()->except('q', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div class="input-group shadow-sm">
                        <input type="search" name="q" class="form-control border-0" placeholder="Nueva búsqueda..." value="{{ request('q') }}">
                        <button class="btn btn-primary-custom" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filtros -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0"><i class="bi bi-funnel me-2 text-danger"></i> Filtros</h5>
                </div>
                <div class="card-body">
                    
                    @if(request()->except('q', 'page'))
                        <div class="mb-3 pb-3 border-bottom">
                            <a href="{{ route('busqueda', ['q' => request('q')]) }}" class="btn btn-sm btn-outline-danger w-100 rounded-pill">
                                <i class="bi bi-x-circle me-1"></i> Limpiar Filtros
                            </a>
                        </div>
                    @endif

                    <!-- Tipo de Documento -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Tipo de Documento</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($tiposDisponibles as $tipo)
                            <li class="mb-2">
                                <a href="{{ request()->fullUrlWithQuery(['tipo' => $tipo->tipo_documento, 'page' => null]) }}" 
                                   class="text-decoration-none d-flex justify-content-between align-items-center {{ request('tipo') == $tipo->tipo_documento ? 'text-danger fw-bold' : 'text-dark' }}">
                                    <span>
                                        @if(request('tipo') == $tipo->tipo_documento)
                                            <i class="bi bi-check2-square me-1"></i>
                                        @else
                                            <i class="bi bi-square me-1 opacity-50"></i>
                                        @endif
                                        {{ $tipo->tipo_documento }}
                                    </span>
                                    <span class="badge bg-light text-dark border rounded-pill">{{ $tipo->total }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Colecciones -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Colecciones</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($coleccionesDisponibles as $col)
                            @if($col->coleccion)
                            <li class="mb-2">
                                <a href="{{ request()->fullUrlWithQuery(['coleccion' => $col->coleccion_id, 'page' => null]) }}" 
                                   class="text-decoration-none d-flex justify-content-between align-items-center {{ request('coleccion') == $col->coleccion_id ? 'text-danger fw-bold' : 'text-dark' }}">
                                    <span class="text-truncate me-2" title="{{ $col->coleccion->nombre }}">
                                        @if(request('coleccion') == $col->coleccion_id)
                                            <i class="bi bi-check2-square me-1"></i>
                                        @else
                                            <i class="bi bi-square me-1 opacity-50"></i>
                                        @endif
                                        {{ $col->coleccion->nombre }}
                                    </span>
                                    <span class="badge bg-light text-dark border rounded-pill">{{ $col->total }}</span>
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>

                    <!-- Año -->
                    <div>
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Año de Publicación</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($aniosDisponibles as $anio)
                            <li class="mb-2">
                                <a href="{{ request()->fullUrlWithQuery(['anio' => $anio->anio, 'page' => null]) }}" 
                                   class="text-decoration-none d-flex justify-content-between align-items-center {{ request('anio') == $anio->anio ? 'text-danger fw-bold' : 'text-dark' }}">
                                    <span>
                                        @if(request('anio') == $anio->anio)
                                            <i class="bi bi-check2-square me-1"></i>
                                        @else
                                            <i class="bi bi-square me-1 opacity-50"></i>
                                        @endif
                                        {{ $anio->anio }}
                                    </span>
                                    <span class="badge bg-light text-dark border rounded-pill">{{ $anio->total }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultados -->
        <div class="col-lg-9">
            @forelse($documentos as $doc)
            <div class="card border-0 shadow-sm rounded-4 mb-4 card-hover-effect">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill mb-2 px-2 py-1">
                            {{ $doc->tipo_documento }}
                        </span>
                        <span class="text-muted small"><i class="bi bi-eye me-1"></i> {{ $doc->vistas }} vistas</span>
                    </div>
                    
                    <h4 class="fw-bold mb-2">
                        <a href="{{ route('documento.publico', $doc->id) }}" class="text-primary-custom text-decoration-none">
                            {{ $doc->titulo }}
                        </a>
                    </h4>
                    
                    <div class="mb-3 text-muted small">
                        <span class="me-3"><i class="bi bi-person me-1"></i> {{ $doc->autor }}</span>
                        <span class="me-3"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($doc->fecha_publicacion)->format('d/m/Y') }}</span>
                        @if($doc->coleccion)
                        <span><i class="bi bi-collection me-1"></i> {{ $doc->coleccion->nombre }}</span>
                        @endif
                    </div>
                    
                    <p class="text-muted mb-3" style="font-size: 0.95rem;">
                        {{ Str::limit($doc->resumen, 250, '...') }}
                    </p>
                    
                    <a href="{{ route('documento.publico', $doc->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        Ver Documento <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-search fs-1 text-muted opacity-50 mb-3 d-block"></i>
                <h4 class="fw-bold text-muted">No se encontraron resultados</h4>
                <p class="text-muted">Intenta buscar con otros términos o elimina algunos filtros.</p>
                <a href="{{ route('busqueda') }}" class="btn btn-primary-custom mt-2">Ver todos los documentos</a>
            </div>
            @endforelse

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-5">
                {{ $documentos->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
.card-hover-effect {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-hover-effect:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
</style>
@endsection
