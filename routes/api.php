<?php

use App\Http\Controllers\AlunosController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EnderecoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('alunos')->group(function(){
    Route::get('/', [AlunosController::class, 'index']);
    Route::get('/{id}', [AlunosController::class, 'getById']);
    Route::post('/', [AlunosController::class, 'createAluno']);
    Route::delete('/{id}', [AlunosController::class, 'deleteAluno']);
    Route::put('/{id}', [AlunosController::class, 'updateAluno']);
});

Route::prefix('endereco')->group(function(){
    Route::get('/', [EnderecoController::class, 'index']);
    Route::get('/{id}', [EnderecoController::class, 'getById']);
    Route::put('/{id}', [EnderecoController::class, 'updateEndereco']);
});


Route::prefix('curso')->group(function(){
    Route::get('/', [CursoController::class, 'getAll']);
    Route::get('/{id}', [CursoController::class, 'getById']);
    Route::post('/', [CursoController::class, 'createCurso']);
    Route::put('/{id}', [CursoController::class, 'updateCurso']);
});

