@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-primary-custom">Dashboard General</h2>
    <div>
        <a href="{{ route('documentos.create') }}" class="btn btn-accent-custom">
            <i class="bi bi-cloud-arrow-up me-2"></i> Nuevo Documento
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-custom p-4 d-flex align-items-center">
            <div class="card-icon-wrapper bg-blue-light mb-0 me-3">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0">{{ $stats['documentos_total'] }}</h3>
                <p class="text-muted mb-0 small text-uppercase">Documentos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 d-flex align-items-center border-warning border-opacity-50">
            <div class="card-icon-wrapper bg-warning bg-opacity-10 text-warning mb-0 me-3">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-warning">{{ $stats['documentos_pendientes'] }}</h3>
                <p class="text-muted mb-0 small text-uppercase">Pendientes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 d-flex align-items-center">
            <div class="card-icon-wrapper bg-blue-light mb-0 me-3">
                <i class="bi bi-diagram-3"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0">{{ $stats['comunidades'] }}</h3>
                <p class="text-muted mb-0 small text-uppercase">Comunidades</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-custom p-4 d-flex align-items-center">
            <div class="card-icon-wrapper bg-blue-light mb-0 me-3">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <h3 class="fw-bold mb-0">{{ $stats['usuarios'] }}</h3>
                <p class="text-muted mb-0 small text-uppercase">Usuarios</p>
            </div>
        </div>
    </div>
</div>

<div class="card-custom">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold">Documentos Recientes</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Título</th>
                        <th>Autor</th>
                        <th>Colección</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos_recientes as $doc)
                    <tr>
                        <td class="ps-4 fw-medium">{{ Str::limit($doc->titulo, 50) }}</td>
                        <td>{{ $doc->autor }}</td>
                        <td>{{ $doc->coleccion->nombre ?? 'N/A' }}</td>
                        <td>
                            @if($doc->estado == 'publicado')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Publicado</span>
                            @elseif($doc->estado == 'en_revisión')
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1">En Revisión</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Rechazado</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $doc->created_at->format('d/m/Y') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('documentos.show', $doc->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No hay documentos recientes.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(count($documentos_recientes) > 0)
    <div class="card-footer bg-white text-center py-3">
        <a href="{{ route('documentos.index') }}" class="text-decoration-none fw-medium">Ver todos los documentos <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
    @endif
</div>
@endsection
