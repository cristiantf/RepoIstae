@extends('layouts.admin')
@section('title', 'Subir Documento')
@section('content')
<div class="mb-4">
    <a href="{{ route('documentos.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Volver a mis documentos
    </a>
    <h2 class="fw-bold mb-0 text-primary-custom">Subir Nuevo Documento</h2>
    <p class="text-muted mt-2">Complete los metadatos Dublin Core para registrar el trabajo en el repositorio.</p>
</div>

<div class="card-custom">
    <div class="card-body p-4 p-lg-5">
        <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-4">1. Metadatos Básicos</h5>
            
            <div class="row g-4 mb-5">
                <div class="col-md-12">
                    <label for="titulo" class="form-label fw-medium">Título del Trabajo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                    @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="autor" class="form-label fw-medium">Autor(es) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('autor') is-invalid @enderror" id="autor" name="autor" placeholder="Ej: Perez, Juan; Lopez, Maria" value="{{ old('autor', auth()->user()->nombre) }}" required>
                    <div class="form-text">Separe múltiples autores con punto y coma (;)</div>
                    @error('autor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="fecha_publicacion" class="form-label fw-medium">Fecha de Publicación (Defensa/Emisión) <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-custom @error('fecha_publicacion') is-invalid @enderror" id="fecha_publicacion" name="fecha_publicacion" value="{{ old('fecha_publicacion') }}" required>
                    @error('fecha_publicacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label for="resumen" class="form-label fw-medium">Resumen / Abstract <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-custom @error('resumen') is-invalid @enderror" id="resumen" name="resumen" rows="5" required>{{ old('resumen') }}</textarea>
                    @error('resumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <h5 class="fw-bold text-dark border-bottom pb-2 mb-4">2. Clasificación</h5>
            
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label for="coleccion_id" class="form-label fw-medium">Comunidad y Colección <span class="text-danger">*</span></label>
                    <select class="form-select form-control-custom @error('coleccion_id') is-invalid @enderror" id="coleccion_id" name="coleccion_id" required>
                        <option value="">Seleccione a dónde pertenece el trabajo...</option>
                        @foreach($colecciones as $comunidadNombre => $cols)
                            <optgroup label="{{ $comunidadNombre }}">
                                @foreach($cols as $col)
                                    <option value="{{ $col->id }}" {{ old('coleccion_id') == $col->id ? 'selected' : '' }}>
                                        {{ $col->nombre }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('coleccion_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="tipo_documento" class="form-label fw-medium">Tipo de Documento <span class="text-danger">*</span></label>
                    <select class="form-select form-control-custom @error('tipo_documento') is-invalid @enderror" id="tipo_documento" name="tipo_documento" required>
                        <option value="Tesis de Grado" {{ old('tipo_documento') == 'Tesis de Grado' ? 'selected' : '' }}>Tesis de Grado</option>
                        <option value="Proyecto de Titulación" {{ old('tipo_documento') == 'Proyecto de Titulación' ? 'selected' : '' }}>Proyecto de Titulación</option>
                        <option value="Artículo Científico" {{ old('tipo_documento') == 'Artículo Científico' ? 'selected' : '' }}>Artículo Científico</option>
                        <option value="Ensayo" {{ old('tipo_documento') == 'Ensayo' ? 'selected' : '' }}>Ensayo</option>
                        <option value="Monografía" {{ old('tipo_documento') == 'Monografía' ? 'selected' : '' }}>Monografía</option>
                    </select>
                    @error('tipo_documento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <h5 class="fw-bold text-dark border-bottom pb-2 mb-4">3. Archivo Adjunto</h5>
            
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <label for="archivo" class="form-label fw-medium">Documento PDF (Máx 50MB) <span class="text-danger">*</span></label>
                    <input class="form-control form-control-custom @error('archivo') is-invalid @enderror" type="file" id="archivo" name="archivo" accept=".pdf" required>
                    <div class="form-text">Solo se permite un archivo en formato PDF. Asegúrese de que no contenga firmas bloqueadas que impidan la lectura de indexadores.</div>
                    @error('archivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr class="my-5 border-secondary opacity-25">
            
            <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded-3">
                <div class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i> Al enviar el documento, pasará a revisión por biblioteca antes de ser publicado.
                </div>
                <button type="submit" class="btn btn-primary-custom px-4 py-2 fw-bold">
                    <i class="bi bi-send me-2"></i> Enviar a Revisión
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
