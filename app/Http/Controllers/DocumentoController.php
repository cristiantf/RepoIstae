<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Coleccion;
use App\Models\Metadato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (in_array($user->rol, ['admin', 'bibliotecario'])) {
            // Bibliotecario ve los pendientes
            $documentos = Documento::where('estado', 'en_revisión')->with('user', 'coleccion')->orderBy('created_at', 'desc')->get();
            $titulo = 'Documentos Pendientes de Revisión';
        } else {
            // Docente/Estudiante ve los suyos
            $documentos = Documento::where('user_id', $user->id)->with('coleccion')->orderBy('created_at', 'desc')->get();
            $titulo = 'Mis Documentos';
        }

        return view('documentos.index', compact('documentos', 'titulo'));
    }

    public function create()
    {
        $colecciones = Coleccion::with('comunidad')->where('activo', 1)->get()->groupBy('comunidad.nombre');
        return view('documentos.create', compact('colecciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'coleccion_id' => 'required|exists:colecciones,id',
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'resumen' => 'required|string',
            'fecha_publicacion' => 'required|date',
            'tipo_documento' => 'required|string',
            'archivo' => 'required|file|mimes:pdf|max:51200', // max 50MB
        ]);

        $file = $request->file('archivo');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documentos', $fileName, 'public');

        $documento = Documento::create([
            'coleccion_id' => $validated['coleccion_id'],
            'user_id' => Auth::id(),
            'titulo' => $validated['titulo'],
            'autor' => $validated['autor'],
            'resumen' => $validated['resumen'],
            'fecha_publicacion' => $validated['fecha_publicacion'],
            'tipo_documento' => $validated['tipo_documento'],
            'archivo_nombre' => $file->getClientOriginalName(),
            'archivo_url' => $filePath,
            'archivo_tamano' => $file->getSize(),
            'estado' => 'en_revisión',
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento enviado a revisión exitosamente.');
    }

    public function show(Documento $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    public function update(Request $request, Documento $documento)
    {
        // Solo para bibliotecarios/admins que aprueban/rechazan
        if (!in_array(Auth::user()->rol, ['admin', 'bibliotecario'])) {
            abort(403);
        }

        $validated = $request->validate([
            'estado' => 'required|in:aprobado,rechazado,publicado',
        ]);

        $documento->update(['estado' => $validated['estado']]);

        return back()->with('success', 'Estado del documento actualizado a ' . $validated['estado']);
    }
}
