@extends('layouts.app')
@section('title', 'Iniciar Sesión')
@section('content')
<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center animate-fade-in">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-header">
                        <i class="bi bi-person-circle fs-1 mb-2 d-block"></i>
                        <h4 class="mb-0">Iniciar Sesión</h4>
                        <p class="mb-0 text-white-50 mt-1">Accede al Repositorio Digital ISTAE</p>
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

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Correo Electrónico Institucional</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control form-control-custom border-start-0 ps-0" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="usuario@istae.edu.ec">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <label for="password" class="form-label fw-medium mb-0">Contraseña</label>
                                    <a href="#" class="text-decoration-none small text-muted">¿Olvidaste tu contraseña?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control form-control-custom border-start-0 ps-0" id="password" name="password" required placeholder="••••••••">
                                </div>
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label text-muted" for="remember">Recordar mi sesión</label>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 mb-3 py-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Entrar
                            </button>

                            <div class="text-center text-muted">
                                ¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Regístrate aquí</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
