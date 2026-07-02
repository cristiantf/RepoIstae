@extends('layouts.admin')
@section('title', $titulo)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-primary-custom">{{ $titulo }}</h2>
    @if(auth()->user()->rol !== 'bibliotecario' && auth()->user()->rol !== 'admin')
    <a href="{{ route('documentos.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-cloud-arrow-up me-1"></i> Subir Documento
    </a>
    @endif
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success rounded-3 mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Título del Documento</th>
                        <th>Autor</th>
                        <th>Colección</th>
                        <th>Fecha Pub.</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $documento)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ Str::limit($documento->titulo, 50) }}</div>
                            <div class="text-muted small"><i class="bi bi-file-earmark-pdf text-danger me-1"></i> {{ $documento->tipo_documento }}</div>
                        </td>
                        <td>{{ $documento->autor }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $documento->coleccion->nombre ?? 'N/A' }}</span></td>
                        <td class="text-muted small">{{ \Carbon\Carbon::parse($documento->fecha_publicacion)->format('d/m/Y') }}</td>
                        <td>
                            @if($documento->estado == 'publicado' || $documento->estado == 'aprobado')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Publicado</span>
                            @elseif($documento->estado == 'en_revisión')
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1">En Revisión</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Rechazado</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('documentos.show', $documento->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                Ver Detalles
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                            No hay documentos para mostrar aquí.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
