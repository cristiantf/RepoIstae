<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comunidad;
use App\Models\Documento;

class PublicoController extends Controller
{
    public function home()
    {
        $comunidades = Comunidad::where('activo', 1)->orderBy('orden')->get();
        
        $stats = [
            'documentos' => Documento::where('estado', 'publicado')->count(),
            'comunidades' => $comunidades->count(),
            'descargas' => Documento::sum('descargas')
        ];

        return view('publico.home', compact('comunidades', 'stats'));
    }
}
