<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('created_at', 'desc')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol' => 'required|in:admin,bibliotecario,docente,estudiante',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['activo'] = 1; // Activo por defecto

        User::create($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'rol' => 'required|in:admin,bibliotecario,docente,estudiante',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo') ? 1 : 0;

        // Evitar que el admin principal se desactive a sí mismo
        if ($usuario->id === auth()->id() && $validated['activo'] === 0) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario->update($validated);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        if ($usuario->documentos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el usuario porque tiene documentos subidos. Considera desactivar su cuenta.');
        }

        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
