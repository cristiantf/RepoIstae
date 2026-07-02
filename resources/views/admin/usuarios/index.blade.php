@extends('layouts.admin')
@section('title', 'Usuarios')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-primary-custom">Gestión de Usuarios</h2>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success rounded-3 mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-10 text-danger rounded-3 mb-4" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card-custom">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Usuario</th>
                        <th>Cédula/Carrera</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Registro</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $usuario->nombre }}</div>
                            <div class="text-muted small">{{ $usuario->email }}</div>
                        </td>
                        <td>
                            <div class="text-dark small">{{ $usuario->cedula ?? 'N/A' }}</div>
                            <div class="text-muted small">{{ $usuario->carrera ?? 'N/A' }}</div>
                        </td>
                        <td>
                            @if($usuario->rol == 'admin')
                                <span class="badge bg-dark">Administrador</span>
                            @elseif($usuario->rol == 'bibliotecario')
                                <span class="badge bg-primary">Bibliotecario</span>
                            @elseif($usuario->rol == 'docente')
                                <span class="badge bg-info text-dark">Docente</span>
                            @else
                                <span class="badge bg-secondary">Estudiante</span>
                            @endif
                        </td>
                        <td>
                            @if($usuario->activo)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Activo</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $usuario->created_at->format('d/m/Y') }}</td>
                        <td class="text-end pe-4">
                            @if($usuario->id !== auth()->id())
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $usuario->id }}" title="Modificar">
                                <i class="bi bi-gear"></i>
                            </button>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    @if($usuario->id !== auth()->id())
                    <div class="modal fade" id="editUserModal{{ $usuario->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow text-start">
                                <div class="modal-header bg-light border-bottom-0">
                                    <h5 class="modal-title fw-bold">Modificar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <p class="mb-3">Modificando a: <strong>{{ $usuario->nombre }}</strong></p>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">Rol en el sistema</label>
                                            <select name="rol" class="form-select form-control-custom">
                                                <option value="estudiante" {{ $usuario->rol == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                                                <option value="docente" {{ $usuario->rol == 'docente' ? 'selected' : '' }}>Docente</option>
                                                <option value="bibliotecario" {{ $usuario->rol == 'bibliotecario' ? 'selected' : '' }}>Bibliotecario</option>
                                                <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-check form-switch mt-4">
                                            <input class="form-check-input" type="checkbox" role="switch" id="activo{{ $usuario->id }}" name="activo" {{ $usuario->activo ? 'checked' : '' }}>
                                            <label class="form-check-label fw-medium" for="activo{{ $usuario->id }}">Permitir inicio de sesión (Activo)</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary-custom">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-3 opacity-50"></i>
                            No hay usuarios registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
