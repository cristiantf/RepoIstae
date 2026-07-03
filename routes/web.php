<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PublicoController;

// Rutas Públicas
Route::get('/', [\App\Http\Controllers\PublicoController::class, 'home'])->name('home');

// Módulo de Búsqueda Pública
Route::get('/buscar', [\App\Http\Controllers\BusquedaController::class, 'index'])->name('busqueda');
Route::get('/documento/{id}', [\App\Http\Controllers\BusquedaController::class, 'show'])->name('documento.publico');

// Módulo de Exploración y Estadísticas
Route::get('/comunidades', [\App\Http\Controllers\ExplorarController::class, 'comunidades'])->name('comunidades');
Route::get('/comunidad/{id}', [\App\Http\Controllers\ExplorarController::class, 'comunidad'])->name('comunidad.publica');
Route::get('/coleccion/{id}', [\App\Http\Controllers\ExplorarController::class, 'coleccion'])->name('coleccion.publica');
Route::get('/estadisticas', [\App\Http\Controllers\EstadisticaController::class, 'index'])->name('estadisticas');

// Autenticación
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

    // Perfil de Usuario
    Route::get('/perfil', [\App\Http\Controllers\PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [\App\Http\Controllers\PerfilController::class, 'update'])->name('perfil.update');

    // Módulo de Documentos (Todos los autenticados)
    Route::resource('documentos', \App\Http\Controllers\DocumentoController::class);

    // Módulo Admin / Dashboard
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Rutas solo para admin y bibliotecario
        Route::middleware('role:admin,bibliotecario')->group(function () {
            Route::resource('comunidades', \App\Http\Controllers\Admin\ComunidadController::class);
            Route::resource('colecciones', \App\Http\Controllers\Admin\ColeccionController::class);
        });

        // Rutas solo para super admin
        Route::middleware('role:admin')->group(function () {
            Route::resource('usuarios', \App\Http\Controllers\Admin\UsuarioController::class);
            Route::get('configuracion', [\App\Http\Controllers\Admin\ConfiguracionController::class, 'index'])->name('configuracion.index');
            Route::put('configuracion', [\App\Http\Controllers\Admin\ConfiguracionController::class, 'update'])->name('configuracion.update');
        });
    });

    // Redirección genérica del dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
});
