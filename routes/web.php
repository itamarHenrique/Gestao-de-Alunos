<?php

use App\Http\Controllers\Auth\AdminController;
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

Route::middleware(['auth:aluno'])->group(function () {
    Route::get('/aluno/dashboard', [LoginController::class, 'dashboard'])->name('aluno.dashboard');
});
Route::middleware(['auth:aluno'])->group(function () {
    Route::get('/perfil', [LoginController::class, 'perfil'])->name('perfil');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/user/dashboard', [LoginController::class, 'dashboard'])->name('user.dashboard');

});
