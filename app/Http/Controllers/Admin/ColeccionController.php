<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coleccion;
use App\Models\Comunidad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ColeccionController extends Controller
{
    public function index()
    {
        $colecciones = Coleccion::with('comunidad')->withCount('documentos')->orderBy('comunidad_id')->orderBy('orden')->get();
        return view('admin.colecciones.index', compact('colecciones'));
    }

    public function create()
    {
        $comunidades = Comunidad::where('activo', 1)->get();
        return view('admin.colecciones.create', compact('comunidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'comunidad_id' => 'required|exists:comunidades,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer',
            'activo' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['activo'] = $request->has('activo') ? 1 : 0;

        Coleccion::create($validated);

        return redirect()->route('admin.colecciones.index')->with('success', 'Colección creada exitosamente.');
    }

    public function edit(Coleccion $coleccione)
    {
        $comunidades = Comunidad::where('activo', 1)->get();
        return view('admin.colecciones.edit', compact('coleccione', 'comunidades'));
    }

    public function update(Request $request, Coleccion $coleccione)
    {
        $validated = $request->validate([
            'comunidad_id' => 'required|exists:comunidades,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer',
            'activo' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['activo'] = $request->has('activo') ? 1 : 0;

        $coleccione->update($validated);

        return redirect()->route('admin.colecciones.index')->with('success', 'Colección actualizada exitosamente.');
    }

    public function destroy(Coleccion $coleccione)
    {
        if ($coleccione->documentos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la colección porque contiene documentos.');
        }

        $coleccione->delete();
        return redirect()->route('admin.colecciones.index')->with('success', 'Colección eliminada exitosamente.');
    }
}
