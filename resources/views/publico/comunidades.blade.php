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
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h3 class="fw-bold text-primary-custom mb-1">
                        <i class="bi bi-diagram-3 me-2 text-danger"></i> {{ $comunidad->nombre }}
                    </h3>
                    @if($comunidad->descripcion)
                    <p class="text-muted mb-0 mt-2">{{ $comunidad->descripcion }}</p>
                    @endif
                    <hr class="mt-4 mb-0 opacity-10">
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-bottom-4">
                        @forelse($comunidad->colecciones as $coleccion)
                        <a href="{{ route('coleccion.publica', $coleccion->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-4 border-light border-bottom">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $coleccion->nombre }}</h5>
                                @if($coleccion->descripcion)
                                <p class="text-muted small mb-0">{{ $coleccion->descripcion }}</p>
                                @endif
                            </div>
                            <span class="badge bg-primary-custom bg-opacity-10 text-primary-custom rounded-pill px-3 py-2 border border-primary border-opacity-25 shadow-sm">
                                {{ $coleccion->documentos_count }} <span class="fw-normal">documentos</span>
                            </span>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted small">
                            No hay colecciones activas en esta comunidad.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-folder-x fs-1 text-muted opacity-50 mb-3 d-block"></i>
                <h4 class="fw-bold text-muted">No hay comunidades disponibles</h4>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
