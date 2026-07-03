<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comunidad;
use App\Models\Coleccion;

class ExplorarController extends Controller
{
    public function comunidades()
    {
        // Obtener todas las comunidades activas con sus colecciones activas
        $comunidades = Comunidad::where('activo', 1)
            ->with(['colecciones' => function($query) {
                $query->where('activo', 1)->orderBy('orden')->withCount(['documentos' => function($q) {
                    $q->whereIn('estado', ['publicado', 'aprobado']);
                }]);
            }])
            ->orderBy('orden')
            ->get();

        return view('publico.comunidades', compact('comunidades'));
    }

    public function coleccion($id)
    {
        // Obtener la colección y sus documentos publicados paginados
        $coleccion = Coleccion::with('comunidad')->where('activo', 1)->findOrFail($id);
        
        $documentos = $coleccion->documentos()
            ->whereIn('estado', ['publicado', 'aprobado'])
            ->orderBy('fecha_publicacion', 'desc')
            ->paginate(10);

        return view('publico.coleccion', compact('coleccion', 'documentos'));
    }
}
