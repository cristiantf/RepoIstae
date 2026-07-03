<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    public function index()
    {
        // Totales Globales
        $totalVistas = Documento::whereIn('estado', ['publicado', 'aprobado'])->sum('vistas');
        $totalDescargas = Documento::whereIn('estado', ['publicado', 'aprobado'])->sum('descargas') ?? 0;
        $totalDocumentos = Documento::whereIn('estado', ['publicado', 'aprobado'])->count();

        // Top 5 Documentos Más Vistos
        $topDocumentos = Documento::whereIn('estado', ['publicado', 'aprobado'])
            ->orderBy('vistas', 'desc')
            ->take(5)
            ->get(['id', 'titulo', 'autor', 'vistas']);

        // Documentos subidos en los últimos 6 meses (para gráfico de barras)
        // Optimizamos extrayendo mes y año de MySQL
        $documentosPorMes = Documento::whereIn('estado', ['publicado', 'aprobado'])
            ->where('fecha_publicacion', '>=', now()->subMonths(6))
            ->select(DB::raw('DATE_FORMAT(fecha_publicacion, "%Y-%m") as mes'), DB::raw('count(*) as total'))
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        // Autores con más documentos publicados
        $topAutores = Documento::whereIn('estado', ['publicado', 'aprobado'])
            ->select('autor', DB::raw('count(*) as total'))
            ->groupBy('autor')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('publico.estadisticas', compact(
            'totalVistas',
            'totalDescargas',
            'totalDocumentos',
            'topDocumentos',
            'documentosPorMes',
            'topAutores'
        ));
    }
}
