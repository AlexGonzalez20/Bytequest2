<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\AuthController;
use App\Models\Usuario;

// Redirigir la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registro
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Recuperar contraseña
Route::get('/password/forgot', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Dashboard protegido por middleware auth
Route::get('/dashboard', function () {
    $usuarios = Usuario::all();
    return view('dashboard', compact('usuarios'));
})->middleware('auth');

// Recursos protegidos por auth
Route::middleware(['auth'])->group(function () {
    Route::resource('cursos', CursoController::class);
    Route::resource('lecciones', LeccionController::class);
});

// Ruta para actualizar el perfil del usuario
Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

// Grupo de rutas para el módulo de vistas
Route::prefix('views')->middleware(['auth'])->group(function () {
    Route::view('/courses', 'Courses')->name('views.courses');
    Route::view('/profile', 'profile')->name('views.profile');
    Route::view('/dashboard', 'dashboard')->name('views.dashboard');
    // Puedes agregar más rutas de vistas aquí
});
