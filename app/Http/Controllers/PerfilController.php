<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'current_password' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8|confirmed|different:current_password',
        ]);

        // Manejar subida de avatar
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Manejar cambio de contraseña
        if ($request->filled('current_password') && $request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado exitosamente.');
    }
}
