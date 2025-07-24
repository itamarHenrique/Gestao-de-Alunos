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

    public function index()
    {
        $cursos = $this->cursoService->getAll();

        return view('admin.cursos.index', compact('cursos'));
    }

    public function getById($id)
    {
        return $this->cursoService->getById($id);

    }

    public function create()
    {
        return view('admin.cursos.create');
    }


    public function store(CursoPostRequest $cursoPostRequest)
    {
        $data = $cursoPostRequest->validated();

        $curso = $this->cursoService->createCurso($data);

        if(!$curso){
            return response()->json(['message' => 'Erro ao criar o curso'], 400);
        }

        return redirect()->route('admin.cursos.index')->with('success', 'Curso criado com sucesso.');
    }

    public function update(CursoUpdateRequest $cursoUpdateRequest, $id)
    {
        $data = $cursoUpdateRequest->validated();

        $curso = $this->cursoService->updateCurso($id, $data);

        if (!$curso) {
            return redirect()->back()->with('error', 'Erro ao atualizar o curso.');
        }

        return redirect()->route('admin.cursos.index')->with('success', 'Curso atualizado com sucesso.');
    }

    public function edit($id)
    {
        $curso = $this->cursoService->getById($id);

        if (!$curso) {
            return redirect()->route('admin.cursos.index')->with('error', 'Curso não encontrado.');
        }

        return view('admin.cursos.edit', compact('curso'));
    }

    public function destroy($id)
    {
        $deletado = $this->cursoService->deleteCurso($id);

        if (!$deletado) {
            return redirect()->back()->with('error', 'Erro ao excluir o curso.');
        }

        return redirect()->route('admin.cursos.index')->with('success', 'Curso excluído com sucesso.');
    }


}
