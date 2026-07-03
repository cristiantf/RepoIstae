<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Coleccion;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        $query = Documento::whereIn('estado', ['publicado', 'aprobado'])->with('coleccion.comunidad');

        // Búsqueda Simple (Query string 'q')
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('titulo', 'like', '%' . $q . '%')
                         ->orWhere('autor', 'like', '%' . $q . '%')
                         ->orWhere('resumen', 'like', '%' . $q . '%')
                         ->orWhere('palabras_clave', 'like', '%' . $q . '%');
            });
        }

        // Filtros (Facetas)
        if ($request->filled('tipo')) {
            $query->where('tipo_documento', $request->input('tipo'));
        }

        if ($request->filled('coleccion')) {
            $query->where('coleccion_id', $request->input('coleccion'));
        }

        if ($request->filled('anio')) {
            $query->whereYear('fecha_publicacion', $request->input('anio'));
        }

        $documentos = $query->orderBy('fecha_publicacion', 'desc')->paginate(10);

        // Obtener facetas (conteos para la barra lateral)
        // Optimizamos obteniendo los counts desde una subconsulta base pero sin los filtros aplicados a sí mismos.
        $baseQuery = Documento::whereIn('estado', ['publicado', 'aprobado']);
        if ($request->filled('q')) {
            $q = $request->input('q');
            $baseQuery->where(function ($qBuilder) use ($q) {
                $qBuilder->where('titulo', 'like', '%' . $q . '%')
                         ->orWhere('autor', 'like', '%' . $q . '%')
                         ->orWhere('resumen', 'like', '%' . $q . '%')
                         ->orWhere('palabras_clave', 'like', '%' . $q . '%');
            });
        }

        $tiposDisponibles = (clone $baseQuery)
            ->selectRaw('tipo_documento, count(*) as total')
            ->groupBy('tipo_documento')
            ->orderBy('total', 'desc')
            ->get();

        $coleccionesDisponibles = (clone $baseQuery)
            ->selectRaw('coleccion_id, count(*) as total')
            ->groupBy('coleccion_id')
            ->with('coleccion')
            ->orderBy('total', 'desc')
            ->get();

        $aniosDisponibles = (clone $baseQuery)
            ->selectRaw('YEAR(fecha_publicacion) as anio, count(*) as total')
            ->groupBy('anio')
            ->orderBy('anio', 'desc')
            ->get();

        return view('publico.busqueda', compact(
            'documentos', 
            'tiposDisponibles', 
            'coleccionesDisponibles', 
            'aniosDisponibles'
        ));
    }

    public function show($id)
    {
        $documento = Documento::with('coleccion.comunidad')
            ->whereIn('estado', ['publicado', 'aprobado'])
            ->findOrFail($id);

        // Incrementar contador de vistas de manera simple
        $documento->increment('vistas');

        return view('publico.documento', compact('documento'));
    }
}
