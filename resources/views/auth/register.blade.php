@extends('layouts.app')
@section('title', 'Registro')
@section('content')
<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center animate-fade-in">
            <div class="col-md-8 col-lg-6">
                <div class="auth-card">
                    <div class="auth-header">
                        <img src="{{ asset('images/logo.webp') }}" alt="Logo ISTAE" height="80" class="mb-3 rounded bg-white p-2 shadow-sm">
                        <h4 class="mb-0">Crear Cuenta</h4>
                        <p class="mb-0 text-white-50 mt-1">Únete a la comunidad académica del ISTAE</p>
                    </div>
                    <div class="auth-body">
                        @if($errors->any())
                            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 mb-4">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-12">
                                    <label for="nombre" class="form-label fw-medium">Nombre Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-custom" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-medium">Correo Electrónico <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-custom" id="email" name="email" value="{{ old('email') }}" required placeholder="ejemplo@istae.edu.ec">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="cedula" class="form-label fw-medium">Cédula</label>
                                    <input type="text" class="form-control form-control-custom" id="cedula" name="cedula" value="{{ old('cedula') }}">
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="carrera" class="form-label fw-medium">Carrera a la que pertenece</label>
                                    <select class="form-select form-control-custom" id="carrera" name="carrera">
                                        <option value="">Seleccione...</option>
                                        <option value="Tecnología en Desarrollo de Software">Tecnología en Desarrollo de Software</option>
                                        <option value="Tecnología en Mecatrónica">Tecnología en Mecatrónica</option>
                                        <option value="Tecnología en Electrónica">Tecnología en Electrónica</option>
                                        <option value="Tecnología en Administración">Tecnología en Administración</option>
                                        <option value="Tecnología en Contabilidad">Tecnología en Contabilidad</option>
                                        <option value="Docente/Administrativo">Docente / Administrativo</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-medium">Contraseña <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control form-control-custom" id="password" name="password" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-medium">Confirmar Contraseña <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control form-control-custom" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 mt-2 mb-3 py-2">
                                <i class="bi bi-person-check me-2"></i> Completar Registro
                            </button>

                            <div class="text-center text-muted">
                                ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Inicia Sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
