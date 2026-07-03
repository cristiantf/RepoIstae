@extends('layouts.app')
@section('title', 'Mi Perfil')
@section('content')

<div class="bg-light py-5 border-bottom">
    <div class="container">
        <h1 class="fw-bold text-primary-custom mb-0"><i class="bi bi-person-badge text-danger me-2"></i> Mi Perfil de Usuario</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Panel de Información del Usuario -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                <div class="bg-blue-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px; overflow: hidden;">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="bi bi-person-fill text-primary-custom" style="font-size: 3rem;"></i>
                    @endif
                </div>
                <h3 class="fw-bold text-dark mb-1">{{ $user->nombre }}</h3>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                
                <div class="mb-4">
                    @if($user->rol === 'admin')
                        <span class="badge bg-danger px-3 py-2 rounded-pill fs-6">Administrador del Sistema</span>
                    @elseif($user->rol === 'bibliotecario')
                        <span class="badge bg-primary px-3 py-2 rounded-pill fs-6">Bibliotecario / Revisor</span>
                    @elseif($user->rol === 'docente')
                        <span class="badge bg-success px-3 py-2 rounded-pill fs-6">Docente / Investigador</span>
                    @else
                        <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">Estudiante</span>
                    @endif
                </div>

                @if(in_array($user->rol, ['admin', 'bibliotecario']))
                    <div class="alert alert-primary bg-primary bg-opacity-10 border-0 text-start mt-auto mb-0">
                        <h6 class="fw-bold"><i class="bi bi-shield-check me-2"></i> Acceso Especial</h6>
                        <p class="small mb-2">Tu tipo de cuenta tiene permisos para acceder al Panel de Control institucional.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary w-100 fw-bold">Ir al Dashboard</a>
                    </div>
                @else
                    <div class="alert alert-secondary bg-secondary bg-opacity-10 border-0 text-start mt-auto mb-0">
                        <h6 class="fw-bold"><i class="bi bi-info-circle me-2"></i> Perfil Académico</h6>
                        <p class="small mb-0">Puedes subir tus trabajos de investigación y hacer seguimiento a su estado de aprobación desde aquí.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Estadísticas y Documentos -->
        <div class="col-lg-8">
            <!-- Estadísticas rápidas -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-3 text-center h-100">
                        <h3 class="fw-bold mb-0">{{ $stats['total_subidos'] }}</h3>
                        <div class="small opacity-75">Doc. Subidos</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 bg-success text-white p-3 text-center h-100">
                        <h3 class="fw-bold mb-0">{{ $stats['aprobados'] }}</h3>
                        <div class="small opacity-75">Publicados</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark p-3 text-center h-100">
                        <h3 class="fw-bold mb-0">{{ $stats['en_revision'] }}</h3>
                        <div class="small opacity-75">En Revisión</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 bg-light text-dark p-3 text-center border h-100">
                        <h3 class="fw-bold text-danger mb-0">{{ $stats['vistas_totales'] }}</h3>
                        <div class="small text-muted">Vistas a tu perfil</div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Mis Documentos -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-primary-custom">Mis Documentos Subidos</h5>
                    <a href="{{ route('documentos.create') }}" class="btn btn-sm btn-accent-custom"><i class="bi bi-plus-lg"></i> Nuevo</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Título del Trabajo</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th class="pe-4 text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($misDocumentos as $doc)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 300px;">{{ $doc->titulo }}</div>
                                        <div class="small text-muted">{{ $doc->tipo_documento }}</div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        @if(in_array($doc->estado, ['publicado', 'aprobado']))
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Publicado</span>
                                        @elseif($doc->estado === 'en_revisión')
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 text-dark">En Revisión</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Rechazado</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        @if(in_array($doc->estado, ['publicado', 'aprobado']))
                                            <a href="{{ route('documento.publico', $doc->id) }}" class="btn btn-sm btn-outline-primary" title="Ver público"><i class="bi bi-eye"></i></a>
                                        @else
                                            <a href="{{ route('documentos.show', $doc->id) }}" class="btn btn-sm btn-outline-secondary" title="Ver detalle/progreso"><i class="bi bi-arrow-right"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        No has subido ningún documento todavía.<br>
                                        <a href="{{ route('documentos.create') }}" class="btn btn-outline-primary mt-3">Subir mi primer documento</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Configuración de Cuenta -->
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="fw-bold mb-0 text-primary-custom"><i class="bi bi-gear me-2"></i> Configuración de Cuenta</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto de Perfil</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <div class="form-text">Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 2MB.</div>
                        </div>

                        <hr class="border-secondary opacity-25 my-4">

                        <h6 class="fw-bold mb-3">Cambiar Contraseña (Opcional)</h6>
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Contraseña Actual</label>
                                <input type="password" name="current_password" class="form-control" placeholder="Requerida solo si deseas cambiarla">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary-custom fw-bold px-4">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
