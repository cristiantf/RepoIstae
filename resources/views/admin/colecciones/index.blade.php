@extends('layouts.admin')
@section('title', 'Colecciones')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-primary-custom">Gestión de Colecciones</h2>
    <a href="{{ route('admin.colecciones.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-1"></i> Nueva Colección
    </a>
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
                        <th class="ps-4">Comunidad</th>
                        <th>Nombre</th>
                        <th>Documentos</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($colecciones as $coleccion)
                    <tr>
                        <td class="ps-4 text-primary-custom fw-semibold">{{ $coleccion->comunidad->nombre }}</td>
                        <td class="fw-medium">{{ $coleccion->nombre }}</td>
                        <td>
                            <span class="badge bg-secondary rounded-pill">{{ $coleccion->documentos_count }}</span>
                        </td>
                        <td class="text-muted fw-bold">{{ $coleccion->orden }}</td>
                        <td>
                            @if($coleccion->activo)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Activo</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.colecciones.edit', $coleccion->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.colecciones.destroy', $coleccion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta colección?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar" {{ $coleccion->documentos_count > 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-collection fs-1 d-block mb-3 opacity-50"></i>
                            No hay colecciones registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
