@extends('layouts.admin')
@section('title', 'Editar Colección')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.colecciones.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Volver a Colecciones
    </a>
    <h2 class="fw-bold mb-0 text-primary-custom">Editar Colección</h2>
</div>

<div class="card-custom">
    <div class="card-body p-4">
        <form action="{{ route('admin.colecciones.update', $coleccione->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="comunidad_id" class="form-label fw-medium">Comunidad a la que pertenece <span class="text-danger">*</span></label>
                    <select class="form-select form-control-custom @error('comunidad_id') is-invalid @enderror" id="comunidad_id" name="comunidad_id" required>
                        @foreach($comunidades as $comunidad)
                            <option value="{{ $comunidad->id }}" {{ (old('comunidad_id', $coleccione->comunidad_id) == $comunidad->id) ? 'selected' : '' }}>
                                {{ $comunidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('comunidad_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="nombre" class="form-label fw-medium">Nombre de la Colección <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-custom @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $coleccione->nombre) }}" required>
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-12">
                    <label for="descripcion" class="form-label fw-medium">Descripción</label>
                    <textarea class="form-control form-control-custom @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $coleccione->descripcion) }}</textarea>
                    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="orden" class="form-label fw-medium">Orden de visualización <span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-custom @error('orden') is-invalid @enderror" id="orden" name="orden" value="{{ old('orden', $coleccione->orden) }}" required min="0">
                    @error('orden') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6 d-flex align-items-center mt-auto pb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" {{ $coleccione->activo ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium" for="activo">Colección Activa</label>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-secondary opacity-25">
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.colecciones.index') }}" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-save me-1"></i> Actualizar Colección
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
