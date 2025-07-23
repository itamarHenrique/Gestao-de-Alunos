<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Rota pública inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
        Route::post('/logout', 'logout')->name('logout'); // Adicione esta linha
});

// // Rotas protegidas para admin
// Route::middleware(['auth', 'perfil:admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');
// });

// // Rotas protegidas para usuário comum
// Route::middleware(['auth', 'perfil:usuario'])->group(function () {
//     Route::get('/user/dashboard', function () {
//         return view('user.dashboard');
//     })->name('user.dashboard');
// });

Route::middleware(['auth:aluno', 'perfil:aluno'])->group(function () {
    Route::get('/aluno/dashboard', function(){
        return view('user.dashboard');
    })->name('aluno.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/user/dashboard', fn () => view('user.dashboard'))->name('user.dashboard');
});
