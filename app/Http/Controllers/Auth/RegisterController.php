<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'carrera' => ['nullable', 'string', 'max:200'],
            'cedula' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol' => 'estudiante',
            'carrera' => $validated['carrera'] ?? null,
            'cedula' => $validated['cedula'] ?? null,
            'activo' => 1,
        ]);

        Auth::login($user);

        return redirect('/');
    }
}
