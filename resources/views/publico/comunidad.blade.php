@extends('layouts.app')
@section('title', $comunidad->nombre)
@section('content')

<div class="bg-light py-5 border-bottom">
    <div class="container">
        <a href="{{ route('comunidades') }}" class="text-decoration-none text-muted mb-3 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Volver a Comunidades
        </a>
        <h1 class="fw-bold text-primary-custom mb-3">
            <i class="bi bi-diagram-3 me-2 text-danger"></i> {{ $comunidad->nombre }}
        </h1>
        @if($comunidad->descripcion)
        <p class="text-muted lead" style="max-width: 800px;">
            {{ $comunidad->descripcion }}
        </p>
        @endif
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">Colecciones en esta comunidad</h3>
                <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $comunidad->colecciones->count() }} Colecciones</span>
            </div>
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="list-group list-group-flush rounded-4">
                    @forelse($comunidad->colecciones as $coleccion)
                    <a href="{{ route('coleccion.publica', $coleccion->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-4 border-light border-bottom transition-hover">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">{{ $coleccion->nombre }}</h5>
                            @if($coleccion->descripcion)
                            <p class="text-muted small mb-0">{{ $coleccion->descripcion }}</p>
                            @endif
                        </div>
                        <span class="badge bg-primary-custom bg-opacity-10 text-dark rounded-pill px-3 py-2 border border-primary border-opacity-25 shadow-sm">
                            {{ $coleccion->documentos_count }} <span class="fw-normal">documentos</span>
                        </span>
                    </a>
                    @empty
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-folder-x fs-1 opacity-50 mb-3 d-block"></i>
                        No hay colecciones activas en esta comunidad.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.transition-hover { transition: all 0.2s ease-in-out; }
.transition-hover:hover { background-color: rgba(0,0,0,0.02); transform: translateX(5px); }
</style>
@endsection
