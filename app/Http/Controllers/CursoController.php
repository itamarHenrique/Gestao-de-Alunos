<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoPostRequest;
use App\Http\Requests\CursoUpdateRequest;
use App\Services\CursoService;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    private $cursoService;

    public function __construct(CursoService $cursoService)
    {
        $this ->cursoService = $cursoService;
    }

    public function getAll()
    {
        return $this->cursoService->getAll();
    }

    public function getById($id)
    {
        return $this->cursoService->getById($id);

    }

    public function createCurso(CursoPostRequest $cursoPostRequest)
    {
        $data = $cursoPostRequest->validated();

        $curso = $this->cursoService->createCurso($data);

        if(!$curso){
            return response()->json(['message' => 'Erro ao criar o curso'], 400);
        }

        return $curso;
    }

    public function updateCurso(CursoUpdateRequest $cursoUpdateRequest, $id)
    {
        $data = $cursoUpdateRequest->validated();

        try{
            $curso = $this->cursoService->updateCurso($id, $data);

            if(!$curso){
                return response()->json(['message' => 'Erro ao atualizar o curso'], 400);
            }

            return response()->json($curso, 200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
