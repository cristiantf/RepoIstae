@extends('layouts.app')
@section('title', $coleccion->nombre)
@section('content')

<div class="bg-light py-5 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('comunidades') }}" class="text-decoration-none text-muted">Comunidades</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $coleccion->nombre }}</li>
            </ol>
        </nav>
        
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill mb-2 px-3 py-2">
                    Colección
                </span>
                <h1 class="fw-bold text-primary-custom mb-2">{{ $coleccion->nombre }}</h1>
                <p class="text-muted mb-0 lead">{{ $coleccion->comunidad->nombre }}</p>
                @if($coleccion->descripcion)
                <p class="text-muted mt-3 mb-0">{{ $coleccion->descripcion }}</p>
                @endif
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <form action="{{ route('busqueda') }}" method="GET">
                    <input type="hidden" name="coleccion" value="{{ $coleccion->id }}">
                    <div class="input-group shadow-sm">
                        <input type="search" name="q" class="form-control border-0 bg-white" placeholder="Buscar en esta colección...">
                        <button class="btn btn-primary-custom" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h4 class="fw-bold mb-4 border-bottom pb-2">Documentos Recientes en {{ $coleccion->nombre }}</h4>
            
            @forelse($documentos as $doc)
            <div class="card border-0 shadow-sm rounded-4 mb-4 card-hover-effect">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill mb-2 px-2 py-1">
                            {{ $doc->tipo_documento }}
                        </span>
                        <span class="text-muted small"><i class="bi bi-eye me-1"></i> {{ $doc->vistas }} vistas</span>
                    </div>
                    
                    <h5 class="fw-bold mb-2">
                        <a href="{{ route('documento.publico', $doc->id) }}" class="text-primary-custom text-decoration-none">
                            {{ $doc->titulo }}
                        </a>
                    </h5>
                    
                    <div class="mb-3 text-muted small">
                        <span class="me-3"><i class="bi bi-person me-1"></i> {{ $doc->autor }}</span>
                        <span><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($doc->fecha_publicacion)->format('d/m/Y') }}</span>
                    </div>
                    
                    <p class="text-muted mb-3 small">
                        {{ Str::limit($doc->resumen, 200, '...') }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted opacity-50 mb-3 d-block"></i>
                <h5 class="text-muted">Aún no hay documentos aprobados en esta colección.</h5>
            </div>
            @endforelse

            <div class="d-flex justify-content-center mt-5">
                {{ $documentos->links('pagination::bootstrap-5') }}
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
