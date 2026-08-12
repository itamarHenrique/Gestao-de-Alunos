<?php

use App\Http\Controllers\AlunosController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\LivroController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Rota pública inicial
Route::get('/', function () {
    return view('login');
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
    Route::get('/admin/alunos', function() {return view ('admin.alunos');})->name('admin.alunos');

});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/alunos', [AlunosController::class,'index'])->name('admin.alunos.index');
    Route::get('/alunos/create', [AlunosController::class, 'create'])->name('admin.alunos.create');
    Route::get('/alunos/{id}/edit',[AlunosController::class, 'edit'])->name('admin.alunos.edit');
    Route::post('/alunos', [AlunosController::class,'createAluno'])->name('admin.alunos.store');
    Route::put('/admin/alunos/{aluno}', [AlunosController::class, 'updateAluno'])->name('admin.alunos.update');
    Route::delete('/alunos/{id}', [AlunosController::class,'deleteAluno'])->name('admin.alunos.delete');
    
    Route::prefix('/cursos')->name('admin.cursos.')->group(function () {
    Route::get('/', [CursoController::class, 'index'])->name('index');
    Route::get('/create', [CursoController::class, 'create'])->name('create');
    Route::post('/', [CursoController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CursoController::class, 'update'])->name('update');
    Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('/livros')->name('admin.livros.')->group(function () {
    Route::get('/', [LivroController::class, 'index'])->name('index');
    Route::get('/create', [LivroController::class, 'create'])->name('create');
    Route::post('/', [LivroController::class, 'store'])->name('store');
    Route::get('/emprestimos', [LivroController::class, 'emprestimos'])->name('emprestimos');
    Route::post('/emprestimos', [LivroController::class, 'emprestar'])->name('emprestimos.store');
    Route::post('/emprestimos/{emprestimoId}/devolver', [LivroController::class, 'devolver'])->name('emprestimos.devolver');
    Route::get('/{id}/edit', [LivroController::class, 'edit'])->name('edit');
    Route::get('/{id}/emprestar', [LivroController::class, 'showEmprestar'])->name('emprestar');
    Route::put('/{id}', [LivroController::class, 'update'])->name('update');
    Route::delete('/{id}', [LivroController::class, 'destroy'])->name('destroy');
    });
    
});

Route::middleware(['auth_biblioteca'])->prefix('biblioteca')->name('biblioteca.')->group(function () {
    Route::get('/', [LivroController::class, 'catalogo'])->name('index');
    Route::get('/meus-emprestimos', [LivroController::class, 'meusEmprestimos'])->name('emprestimos');
    Route::get('/{id}/baixar', [LivroController::class, 'baixar'])->name('download');
    Route::get('/{id}', [LivroController::class, 'show'])->name('show');
});


    