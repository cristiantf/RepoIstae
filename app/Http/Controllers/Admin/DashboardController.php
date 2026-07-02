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
    public function index()
    {
        $stats = [
            'documentos_total' => Documento::count(),
            'documentos_pendientes' => Documento::where('estado', 'en_revisión')->count(),
            'comunidades' => Comunidad::count(),
            'usuarios' => User::count(),
        ];

        $documentos_recientes = Documento::with(['user', 'coleccion'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'documentos_recientes'));
    }
}
