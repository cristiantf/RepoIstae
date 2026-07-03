<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion;

class ConfiguracionController extends Controller
{
    public function index()
    {
        // Asegurar que existan los valores por defecto
        $configs = [
            'registro_abierto' => '1',
            'validacion_admin_registro' => '0',
            'subida_estudiantes' => '1',
            'subida_docentes' => '1'
        ];

        foreach ($configs as $clave => $valorDefault) {
            Configuracion::firstOrCreate(
                ['clave' => $clave],
                ['valor' => $valorDefault, 'descripcion' => 'Ajuste del sistema: ' . $clave]
            );
        }

        // Obtener todos los ajustes
        $configuraciones = Configuracion::all()->keyBy('clave');

        return view('admin.configuracion', compact('configuraciones'));
    }

    public function update(Request $request)
    {
        $keys = [
            'registro_abierto',
            'validacion_admin_registro',
            'subida_estudiantes',
            'subida_docentes'
        ];

        foreach ($keys as $key) {
            // El checkbox envía '1' si está marcado, no se envía si está desmarcado
            $valor = $request->has($key) ? '1' : '0';
            
            Configuracion::where('clave', $key)->update(['valor' => $valor]);
        }

        return redirect()->back()->with('success', 'Configuración actualizada exitosamente.');
    }
}
