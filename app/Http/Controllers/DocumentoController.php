<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Coleccion;
use App\Models\Metadato;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Documento::with('coleccion', 'user');

        if (in_array($user->rol, ['admin', 'bibliotecario'])) {
            $titulo = 'Gestión de Documentos';
        } else {
            $query->where('user_id', $user->id);
            $titulo = 'Mis Documentos';
        }

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->q . '%')
                  ->orWhere('autor', 'like', '%' . $request->q . '%');
            });
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $documentos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('documentos.index', compact('documentos', 'titulo'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->rol === 'estudiante') {
            $allow = Configuracion::where('clave', 'subida_estudiantes')->value('valor') ?? '1';
            if ($allow === '0') return redirect()->route('documentos.index')->withErrors(['error' => 'La subida de documentos para estudiantes está deshabilitada temporalmente.']);
        }
        if ($user->rol === 'docente') {
            $allow = Configuracion::where('clave', 'subida_docentes')->value('valor') ?? '1';
            if ($allow === '0') return redirect()->route('documentos.index')->withErrors(['error' => 'La subida de documentos para docentes está deshabilitada temporalmente.']);
        }

        $colecciones = Coleccion::with('comunidad')->where('activo', 1)->get()->groupBy('comunidad.nombre');
        return view('documentos.create', compact('colecciones'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->rol === 'estudiante') {
            $allow = Configuracion::where('clave', 'subida_estudiantes')->value('valor') ?? '1';
            if ($allow === '0') return redirect()->route('documentos.index')->withErrors(['error' => 'La subida de documentos para estudiantes está deshabilitada temporalmente.']);
        }
        if ($user->rol === 'docente') {
            $allow = Configuracion::where('clave', 'subida_docentes')->value('valor') ?? '1';
            if ($allow === '0') return redirect()->route('documentos.index')->withErrors(['error' => 'La subida de documentos para docentes está deshabilitada temporalmente.']);
        }

        $validated = $request->validate([
            'coleccion_id' => 'required|exists:colecciones,id',
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'resumen' => 'required|string',
            'palabras_clave' => 'nullable|string|max:500',
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
            'palabras_clave' => $validated['palabras_clave'] ?? null,
            'fecha_publicacion' => $validated['fecha_publicacion'],
            'tipo_documento' => $validated['tipo_documento'],
            'archivo_nombre' => $file->getClientOriginalName(),
            'archivo_url' => $filePath,
            'archivo_tamano' => $file->getSize(),
            'estado' => 'en_revisión',
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento enviado a revisión exitosamente.');
    }

    public function edit(Documento $documento)
    {
        $user = Auth::user();
        if ($documento->user_id !== $user->id && !in_array($user->rol, ['admin', 'bibliotecario'])) {
            abort(403);
        }
        $colecciones = Coleccion::with('comunidad')->where('activo', 1)->get()->groupBy('comunidad.nombre');
        return view('documentos.edit', compact('documento', 'colecciones'));
    }

    public function show(Documento $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    public function update(Request $request, Documento $documento)
    {
        $user = Auth::user();
        $isAdmin = in_array($user->rol, ['admin', 'bibliotecario']);
        
        if ($documento->user_id !== $user->id && !$isAdmin) {
            abort(403);
        }

        // Si la petición solo tiene "estado" y "_token" / "_method" (es decir, desde el panel rápido)
        if ($request->has('estado') && count($request->all()) <= 4 && !$request->has('titulo')) {
            if (!$isAdmin) abort(403);
            $validated = $request->validate([
                'estado' => 'required|in:en_revisión,aprobado,rechazado,publicado',
            ]);
            $documento->update(['estado' => $validated['estado']]);
            return back()->with('success', 'Estado del documento actualizado a ' . $validated['estado']);
        }

        // De lo contrario, es una edición completa de metadatos
        $rules = [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'resumen' => 'required|string',
            'palabras_clave' => 'nullable|string|max:500',
            'fecha_publicacion' => 'required|date',
            'tipo_documento' => 'required|string|max:50',
            'coleccion_id' => 'required|exists:colecciones,id',
            'archivo' => 'nullable|file|mimes:pdf|max:51200',
        ];

        if ($isAdmin && $request->has('estado')) {
            $rules['estado'] = 'required|in:en_revisión,aprobado,rechazado,publicado';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documentos', $fileName, 'public');
            
            if ($documento->archivo_url && Storage::disk('public')->exists($documento->archivo_url)) {
                Storage::disk('public')->delete($documento->archivo_url);
            }

            $validated['archivo_nombre'] = $file->getClientOriginalName();
            $validated['archivo_url'] = $filePath;
            $validated['archivo_tamano'] = $file->getSize();
        }

        $documento->update($validated);

        return redirect()->route('documentos.show', $documento->id)->with('success', 'Documento actualizado correctamente.');
    }
}
