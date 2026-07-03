<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comunidad;
use App\Models\Coleccion;
use App\Models\Documento;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'documentos_total' => Documento::count(),
            'documentos_pendientes' => Documento::where('estado', 'en_revisión')->count(),
            'comunidades' => Comunidad::count(),
            'usuarios' => User::count(),
        ];

        $query = Documento::with(['user', 'coleccion']);

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->q . '%')
                  ->orWhere('autor', 'like', '%' . $request->q . '%');
            });
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $documentos_recientes = $query->orderBy('created_at', 'desc')->paginate(5)->withQueryString();

        return view('admin.dashboard', compact('stats', 'documentos_recientes'));
    }
}
