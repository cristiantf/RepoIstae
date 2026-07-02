@extends('layouts.admin')
@section('title', 'Detalle de Documento')
@section('content')
<div class="mb-4">
    <a href="{{ route('documentos.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Volver a la lista
    </a>
    <div class="d-flex justify-content-between align-items-start">
        <h2 class="fw-bold mb-0 text-primary-custom">{{ $documento->titulo }}</h2>
        <div>
            @if($documento->estado == 'publicado' || $documento->estado == 'aprobado')
                <span class="badge bg-success fs-6">Publicado</span>
            @elseif($documento->estado == 'en_revisión')
                <span class="badge bg-warning text-dark fs-6">En Revisión</span>
            @else
                <span class="badge bg-danger fs-6">Rechazado</span>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success rounded-3 mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-4">
    <!-- Metadata Column -->
    <div class="col-lg-8">
        <div class="card-custom h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-danger"></i> Metadatos del Documento</h5>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted fw-medium">Autor(es)</div>
                    <div class="col-sm-9 fw-bold text-dark">{{ $documento->autor }}</div>
                </div>
                <hr class="border-secondary opacity-10">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted fw-medium">Fecha Pub.</div>
                    <div class="col-sm-9">{{ \Carbon\Carbon::parse($documento->fecha_publicacion)->format('d de F, Y') }}</div>
                </div>
                <hr class="border-secondary opacity-10">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted fw-medium">Comunidad</div>
                    <div class="col-sm-9">{{ $documento->coleccion->comunidad->nombre ?? 'N/A' }}</div>
                </div>
                <hr class="border-secondary opacity-10">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted fw-medium">Colección</div>
                    <div class="col-sm-9">{{ $documento->coleccion->nombre ?? 'N/A' }}</div>
                </div>
                <hr class="border-secondary opacity-10">
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted fw-medium">Tipo Doc.</div>
                    <div class="col-sm-9">{{ $documento->tipo_documento }}</div>
                </div>
                <hr class="border-secondary opacity-10">
                <div class="row mb-3">
                    <div class="col-sm-12 text-muted fw-medium mb-2">Resumen / Abstract</div>
                    <div class="col-sm-12 text-dark text-justify" style="line-height: 1.7;">
                        {{ $documento->resumen }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions and File Column -->
    <div class="col-lg-4">
        <div class="card-custom mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i> Archivo Adjunto</h5>
            </div>
            <div class="card-body p-4 text-center">
                <i class="bi bi-file-pdf fs-1 text-danger mb-3 d-block"></i>
                <h6 class="fw-bold text-truncate" title="{{ $documento->archivo_nombre }}">{{ $documento->archivo_nombre }}</h6>
                <p class="text-muted small mb-4">{{ number_format($documento->archivo_tamano / 1048576, 2) }} MB</p>
                
                <a href="{{ asset('storage/' . $documento->archivo_url) }}" target="_blank" class="btn btn-outline-danger w-100 rounded-pill">
                    <i class="bi bi-eye me-2"></i> Ver PDF
                </a>
            </div>
        </div>

        @if(in_array(auth()->user()->rol, ['admin', 'bibliotecario']) && $documento->estado === 'en_revisión')
        <div class="card-custom border-primary border">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-check-circle me-2"></i> Revisión</h5>
            </div>
            <div class="card-body p-4">
                <p class="small text-muted mb-4">Como revisor, valida que el documento cumpla con los estándares institucionales antes de publicarlo abiertamente.</p>
                <form action="{{ route('documentos.update', $documento->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="d-grid gap-2">
                        <button type="submit" name="estado" value="publicado" class="btn btn-success fw-bold">
                            Aprobar y Publicar
                        </button>
                        <button type="submit" name="estado" value="rechazado" class="btn btn-outline-danger fw-bold">
                            Rechazar Documento
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
