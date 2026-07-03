<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Documento;

class PerfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Cargar los documentos subidos por el usuario actual
        $misDocumentos = Documento::where('user_id', $user->id)
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        // Calcular algunas estadísticas rápidas del usuario
        $stats = [
            'total_subidos' => $misDocumentos->count(),
            'aprobados' => $misDocumentos->whereIn('estado', ['publicado', 'aprobado'])->count(),
            'en_revision' => $misDocumentos->where('estado', 'en_revisión')->count(),
            'rechazados' => $misDocumentos->where('estado', 'rechazado')->count(),
            'vistas_totales' => $misDocumentos->sum('vistas'),
        ];

        return view('perfil.index', compact('user', 'misDocumentos', 'stats'));
    }
}
