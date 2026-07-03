@extends('layouts.admin')
@section('title', 'Configuración del Sistema')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-primary-custom"><i class="bi bi-gear me-2"></i> Configuración del Sistema</h2>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success rounded-3 mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card-custom">
    <div class="card-body p-4 p-lg-5">
        <form action="{{ route('admin.configuracion.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <h5 class="fw-bold text-dark border-bottom pb-2 mb-4">Registro y Autenticación</h5>
            
            <div class="row g-4 mb-5">
                <div class="col-md-12">
                    <div class="form-check form-switch fs-5 mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="registro_abierto" name="registro_abierto" value="1" {{ isset($configuraciones['registro_abierto']) && $configuraciones['registro_abierto']->valor == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium" for="registro_abierto">Permitir Registro de Nuevos Usuarios</label>
                    </div>
                    <p class="text-muted small ms-5">Si se desactiva, los usuarios no podrán crear cuentas por sí mismos. Solo los administradores podrán crearlas desde el panel de Usuarios.</p>
                </div>
                
                <div class="col-md-12">
                    <div class="form-check form-switch fs-5 mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="validacion_admin_registro" name="validacion_admin_registro" value="1" {{ isset($configuraciones['validacion_admin_registro']) && $configuraciones['validacion_admin_registro']->valor == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium" for="validacion_admin_registro">Requerir Validación del Administrador para Cuentas Nuevas</label>
                    </div>
                    <p class="text-muted small ms-5">Si se activa, los nuevos usuarios creados quedarán como "Inactivos" por defecto y no podrán iniciar sesión hasta que un administrador los apruebe.</p>
                </div>
            </div>

            <h5 class="fw-bold text-dark border-bottom pb-2 mb-4">Políticas de Subida de Documentos</h5>
            
            <div class="row g-4 mb-5">
                <div class="col-md-12">
                    <div class="form-check form-switch fs-5 mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="subida_estudiantes" name="subida_estudiantes" value="1" {{ isset($configuraciones['subida_estudiantes']) && $configuraciones['subida_estudiantes']->valor == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium" for="subida_estudiantes">Permitir Subida de Documentos a Estudiantes</label>
                    </div>
                    <p class="text-muted small ms-5">Activa o desactiva la capacidad de los estudiantes para subir trabajos de titulación u otros documentos.</p>
                </div>

                <div class="col-md-12">
                    <div class="form-check form-switch fs-5 mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="subida_docentes" name="subida_docentes" value="1" {{ isset($configuraciones['subida_docentes']) && $configuraciones['subida_docentes']->valor == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium" for="subida_docentes">Permitir Subida de Documentos a Docentes</label>
                    </div>
                    <p class="text-muted small ms-5">Activa o desactiva la capacidad de los docentes para subir artículos y proyectos de investigación.</p>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary-custom px-4 py-2 fw-bold">
                    <i class="bi bi-save me-2"></i> Guardar Configuración
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
