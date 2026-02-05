<?php

use App\Http\Controllers\CandidatosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VacanteController;
use App\Http\Livewire\Profile\Show;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class )->name('home');

Route::get('/dashboard', [VacanteController::class, 'index'])->middleware(['auth', 'verified', 'rol.reclutador'])->name('vacantes.index');
Route::get('/vacantes/create', [VacanteController::class, 'create'])->middleware(['auth', 'verified'])->name('vacantes.create');
Route::get('/vacantes/{vacante}/edit', [VacanteController::class, 'edit'])->middleware(['auth', 'verified'])->name('vacantes.edit');
Route::get('/vacantes/{vacante}', [VacanteController::class, 'show'])->name('vacantes.show');
Route::get('/candidatos/{vacante}', [CandidatosController::class, 'index'])->middleware(['auth', 'verified', 'rol.reclutador'])->name('candidatos.index');

Route::get('/perfiles/{user:username}', [UsuarioController::class, 'show'])->name('usuarios.show');
Route::get('/perfiles/id/{user}', [UsuarioController::class, 'showById'])->name('usuarios.showById');

// Notificaciones
Route::get('/notificaciones', NotificacionController::class)->middleware(['auth', 'verified', 'rol.reclutador'])->name('notificaciones');

// Perfil de usuario
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', Show::class)->name('profile.show');
    // ... otras rutas del perfil
});

require __DIR__.'/auth.php';
