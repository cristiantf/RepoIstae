@extends('layouts.app')
@section('title', 'Estadísticas del Repositorio')
@section('content')

<!-- Cargar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="bg-light py-5 border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold text-primary-custom mb-3">Estadísticas Institucionales</h1>
        <p class="text-muted lead mx-auto" style="max-width: 700px;">
            Métricas de impacto e indicadores de acceso abierto del Repositorio Digital ISTAE.
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- Tarjetas de Resumen -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 py-4" style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);">
                <div class="card-body">
                    <i class="bi bi-file-earmark-text display-4 text-white opacity-75 mb-3 d-block"></i>
                    <h2 class="display-5 fw-bold text-white mb-0">{{ number_format($totalDocumentos) }}</h2>
                    <p class="text-white opacity-75 fw-medium text-uppercase tracking-wide mt-2">Trabajos Publicados</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 py-4 bg-white border-bottom border-danger border-4">
                <div class="card-body">
                    <i class="bi bi-eye display-4 text-danger opacity-75 mb-3 d-block"></i>
                    <h2 class="display-5 fw-bold text-dark mb-0">{{ number_format($totalVistas) }}</h2>
                    <p class="text-muted fw-medium text-uppercase tracking-wide mt-2">Visualizaciones Globales</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 py-4 bg-white border-bottom border-primary border-4">
                <div class="card-body">
                    <i class="bi bi-cloud-arrow-down display-4 text-primary opacity-75 mb-3 d-block"></i>
                    <h2 class="display-5 fw-bold text-dark mb-0">{{ number_format($totalDescargas) }}</h2>
                    <p class="text-muted fw-medium text-uppercase tracking-wide mt-2">Descargas de PDF</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <!-- Gráfico -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="fw-bold mb-0 text-primary-custom"><i class="bi bi-bar-chart-fill me-2 text-danger"></i> Producción Científica (Últimos meses)</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="chartMeses" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Documentos -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="fw-bold mb-0 text-primary-custom"><i class="bi bi-trophy-fill me-2 text-warning"></i> Top 5 Más Vistos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-bottom-4">
                        @forelse($topDocumentos as $index => $doc)
                        <a href="{{ route('documento.publico', $doc->id) }}" class="list-group-item list-group-item-action d-flex align-items-center p-3 border-light border-bottom">
                            <h4 class="fw-bold text-muted mb-0 me-3 opacity-50">#{{ $index + 1 }}</h4>
                            <div>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;" title="{{ $doc->titulo }}">
                                    {{ $doc->titulo }}
                                </div>
                                <div class="text-muted small"><i class="bi bi-eye text-danger"></i> {{ number_format($doc->vistas) }} vistas</div>
                            </div>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted small">No hay datos suficientes.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Top Autores -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom pt-4 pb-3 px-4">
                    <h5 class="fw-bold mb-0 text-primary-custom"><i class="bi bi-pen-fill me-2 text-primary"></i> Autores Destacados</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-bottom-4">
                        @forelse($topAutores as $autor)
                        <div class="list-group-item d-flex justify-content-between align-items-center p-3 border-light border-bottom">
                            <div class="fw-medium text-dark text-truncate" style="max-width: 180px;">{{ $autor->autor }}</div>
                            <span class="badge bg-light text-dark border rounded-pill">{{ $autor->total }} trabajos</span>
                        </div>
                        @empty
                        <div class="p-4 text-center text-muted small">No hay datos suficientes.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('chartMeses').getContext('2d');
    
    // Datos procesados en el controlador pasados a Javascript
    const labels = {!! json_encode($documentosPorMes->pluck('mes')) !!};
    const data = {!! json_encode($documentosPorMes->pluck('total')) !!};
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Trabajos Publicados',
                data: data,
                backgroundColor: 'rgba(211, 47, 47, 0.8)', // accent-custom
                borderColor: 'rgba(211, 47, 47, 1)',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection
