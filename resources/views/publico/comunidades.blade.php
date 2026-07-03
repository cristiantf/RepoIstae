@extends('layouts.app')
@section('title', 'Comunidades y Colecciones')
@section('content')

<div class="bg-light py-5 border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold text-primary-custom mb-3">Comunidades y Colecciones</h1>
        <p class="text-muted lead mx-auto" style="max-width: 700px;">
            Navegue a través de la estructura jerárquica del repositorio. Los documentos se organizan en comunidades (facultades/departamentos) y colecciones (carreras).
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @forelse($comunidades as $comunidad)
            <a href="{{ route('comunidad.publica', $comunidad->id) }}" class="card border-0 shadow-sm rounded-4 mb-4 text-decoration-none transition-hover-up">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold text-primary-custom mb-1">
                            <i class="bi bi-diagram-3 me-2 text-danger"></i> {{ $comunidad->nombre }}
                        </h4>
                        @if($comunidad->descripcion)
                        <p class="text-muted mb-0 mt-2">{{ $comunidad->descripcion }}</p>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-light text-dark rounded-pill px-3 py-2 border">
                            {{ $comunidad->colecciones_count }} colecciones
                        </span>
                        <i class="bi bi-chevron-right text-muted fs-4"></i>
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-folder-x fs-1 text-muted opacity-50 mb-3 d-block"></i>
                <h4 class="fw-bold text-muted">No hay comunidades disponibles</h4>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.transition-hover-up { transition: all 0.3s ease; }
.transition-hover-up:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
</style>
@endsection
