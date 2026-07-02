@extends('layouts.admin')
@section('title', 'Nueva Comunidad')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.comunidades.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Volver a Comunidades
    </a>
    <h2 class="fw-bold mb-0 text-primary-custom">Nueva Comunidad</h2>
</div>

<div class="card-custom">
    <div class="card-body p-4">
        <form action="{{ route('admin.comunidades.store') }}" method="POST">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-8">
                    <label for="nombre" class="form-label fw-medium">Nombre de la Comunidad <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="orden" class="form-label fw-medium">Orden de visualización <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-custom @error('orden') is-invalid @enderror" id="orden" name="orden" value="{{ old('orden', 1) }}" required min="0">
                    @error('orden') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-12">
                    <label for="descripcion" class="form-label fw-medium">Descripción</label>
                    <textarea class="form-control form-control-custom @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="4">{{ old('descripcion') }}</textarea>
                    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" value="1" checked>
                        <label class="form-check-label fw-medium" for="activo">Comunidad Activa</label>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-secondary opacity-25">
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.comunidades.index') }}" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-save me-1"></i> Guardar Comunidad
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
