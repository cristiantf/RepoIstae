@extends('layouts.app')
@section('title', $documento->titulo)
@section('content')

<!-- Metadatos SEO ocultos -->
@section('meta')
<meta name="description" content="{{ Str::limit($documento->resumen, 160) }}">
<meta name="author" content="{{ $documento->autor }}">
<meta name="citation_title" content="{{ $documento->titulo }}">
<meta name="citation_author" content="{{ $documento->autor }}">
<meta name="citation_publication_date" content="{{ \Carbon\Carbon::parse($documento->fecha_publicacion)->format('Y/m/d') }}">
<meta name="citation_pdf_url" content="{{ asset('storage/' . $documento->archivo_url) }}">
<meta name="citation_language" content="es">
<meta name="citation_dissertation_institution" content="Instituto Superior Tecnológico Alberto Enríquez (ISTAE)">
@endsection

<div class="bg-light py-5 border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('busqueda') }}" class="text-decoration-none text-muted">Repositorio</a></li>
                @if($documento->coleccion)
                <li class="breadcrumb-item"><a href="{{ route('busqueda', ['coleccion' => $documento->coleccion_id]) }}" class="text-decoration-none text-muted">{{ $documento->coleccion->nombre }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">Detalle</li>
            </ol>
        </nav>
        
        <div class="row align-items-center">
            <div class="col-lg-9">
                <h1 class="fw-bold text-primary-custom mb-3">{{ $documento->titulo }}</h1>
                <div class="d-flex flex-wrap gap-3 text-muted mb-4 mb-lg-0">
                    <span><i class="bi bi-person me-1"></i> {{ $documento->autor }}</span>
                    <span><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($documento->fecha_publicacion)->format('d de F, Y') }}</span>
                    <span><i class="bi bi-eye me-1"></i> {{ $documento->vistas }} Vistas</span>
                    <span><i class="bi bi-cloud-arrow-down me-1"></i> {{ $documento->descargas ?? 0 }} Descargas</span>
                </div>
            </div>
            <div class="col-lg-3 text-lg-end mt-4 mt-lg-0">
                <a href="{{ asset('storage/' . $documento->archivo_url) }}" target="_blank" class="btn btn-danger btn-lg rounded-pill shadow px-4">
                    <i class="bi bi-file-earmark-pdf me-2"></i> Descargar PDF
                </a>
                <div class="text-muted small mt-2">
                    Tamaño: {{ number_format($documento->archivo_tamano / 1048576, 2) }} MB
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <h4 class="fw-bold text-dark border-bottom pb-2 mb-4">Resumen / Abstract</h4>
            <p class="text-justify mb-5" style="line-height: 1.8; font-size: 1.05rem;">
                {{ $documento->resumen }}
            </p>

            <h4 class="fw-bold text-dark border-bottom pb-2 mb-4">Ficha Técnica</h4>
            <table class="table table-striped table-bordered border-light">
                <tbody>
                    <tr>
                        <th class="w-25 bg-light text-muted fw-bold">Título</th>
                        <td>{{ $documento->titulo }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light text-muted fw-bold">Autor(es)</th>
                        <td>{{ $documento->autor }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light text-muted fw-bold">Tipo de Documento</th>
                        <td>{{ $documento->tipo_documento }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light text-muted fw-bold">Fecha de Publicación</th>
                        <td>{{ \Carbon\Carbon::parse($documento->fecha_publicacion)->format('d/m/Y') }}</td>
                    </tr>
                    @if($documento->coleccion)
                    <tr>
                        <th class="bg-light text-muted fw-bold">Comunidad / Facultad</th>
                        <td>{{ $documento->coleccion->comunidad->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light text-muted fw-bold">Colección / Carrera</th>
                        <td>{{ $documento->coleccion->nombre }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th class="bg-light text-muted fw-bold">URI del Recurso</th>
                        <td><a href="{{ route('documento.publico', $documento->id) }}">{{ route('documento.publico', $documento->id) }}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="col-lg-4">
            <!-- Sidebar derecho público -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-file-pdf fs-1 text-danger mb-3 d-block"></i>
                    <h5 class="fw-bold mb-3">Visor Integrado</h5>
                    <p class="text-muted small mb-4">El archivo está disponible en formato Adobe PDF. Puede visualizarlo directamente en su navegador.</p>
                    <a href="{{ asset('storage/' . $documento->archivo_url) }}" target="_blank" class="btn btn-outline-primary-custom w-100 rounded-pill">
                        <i class="bi bi-box-arrow-up-right me-2"></i> Abrir en visor
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-primary-custom text-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-quote me-2 text-danger"></i> Cómo citar</h5>
                    <p class="small opacity-75 mb-0" style="user-select: all;">
                        {{ $documento->autor }}. ({{ \Carbon\Carbon::parse($documento->fecha_publicacion)->format('Y') }}). <em>{{ $documento->titulo }}</em> [{{ $documento->tipo_documento }}]. Repositorio Institucional ISTAE. {{ route('documento.publico', $documento->id) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
