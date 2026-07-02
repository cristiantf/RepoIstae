<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comunidad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComunidadController extends Controller
{
    public function index()
    {
        $comunidades = Comunidad::withCount('colecciones')->orderBy('orden')->get();
        return view('admin.comunidades.index', compact('comunidades'));
    }

    public function create()
    {
        return view('admin.comunidades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:comunidades',
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer',
            'activo' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['activo'] = $request->has('activo') ? 1 : 0;

        Comunidad::create($validated);

        return redirect()->route('admin.comunidades.index')->with('success', 'Comunidad creada exitosamente.');
    }

    public function edit(Comunidad $comunidade)
    {
        return view('admin.comunidades.edit', compact('comunidade'));
    }

    public function update(Request $request, Comunidad $comunidade)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:comunidades,nombre,' . $comunidade->id,
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer',
            'activo' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['activo'] = $request->has('activo') ? 1 : 0;

        $comunidade->update($validated);

        return redirect()->route('admin.comunidades.index')->with('success', 'Comunidad actualizada exitosamente.');
    }

    public function destroy(Comunidad $comunidade)
    {
        if ($comunidade->colecciones()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la comunidad porque contiene colecciones.');
        }

        $comunidade->delete();
        return redirect()->route('admin.comunidades.index')->with('success', 'Comunidad eliminada exitosamente.');
    }
}
