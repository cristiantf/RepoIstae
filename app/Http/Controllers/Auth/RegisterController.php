<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Configuracion;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $registroAbierto = Configuracion::where('clave', 'registro_abierto')->value('valor') ?? '1';
        
        if ($registroAbierto === '0') {
            return redirect()->route('login')->withErrors(['email' => 'El registro de nuevos usuarios está temporalmente deshabilitado por el administrador.']);
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $registroAbierto = Configuracion::where('clave', 'registro_abierto')->value('valor') ?? '1';
        if ($registroAbierto === '0') {
            return redirect()->route('login')->withErrors(['email' => 'El registro de nuevos usuarios está cerrado.']);
        }

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'carrera' => ['nullable', 'string', 'max:200'],
            'cedula' => ['nullable', 'string', 'max:20'],
        ]);

        $validacionAdmin = Configuracion::where('clave', 'validacion_admin_registro')->value('valor') ?? '0';
        $esActivo = ($validacionAdmin === '1') ? 0 : 1;

        $user = User::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol' => 'estudiante',
            'carrera' => $validated['carrera'] ?? null,
            'cedula' => $validated['cedula'] ?? null,
            'activo' => $esActivo,
        ]);

        if ($esActivo === 0) {
            return redirect()->route('login')->with('success', 'Tu cuenta ha sido creada exitosamente, pero requiere ser activada por un administrador antes de poder ingresar.');
        }

        Auth::login($user);

        return redirect('/');
    }
}
