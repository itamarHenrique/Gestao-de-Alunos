<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlunoPostRequest;
use App\Http\Requests\AlunoUpdateRequest;
use App\Http\Requests\EnderecoPostRequest;
use App\Http\Resources\AlunoResource;
use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Endereco;
use App\Services\AlunoService;
use App\Services\CursoService;
use App\Services\EnderecoService;
use Illuminate\Http\Request;

class AlunosController extends Controller
{
    private $alunoService;
    private $enderecoService;
    private $aluno;
    private $endereco;
    private $curso;
    private $cursoService;



    public function __construct(AlunoService $alunoService, EnderecoService $enderecoService, CursoService $cursoService, Aluno $aluno, Endereco $endereco, Curso $curso)
    {
        $this->alunoService = $alunoService;
        $this->enderecoService = $enderecoService;
        $this->aluno = $aluno;
        $this->endereco = $endereco;
        $this->curso = $curso;
        $this->cursoService = $cursoService;
    }

    public function index()
    {
        $alunos = $this->alunoService->getAll();

        return AlunoResource::collection($alunos);
    }

    public function getById($id)
    {
        $aluno = $this->alunoService->getById($id);

        return new AlunoResource($aluno);
    }

    public function deleteAluno($id)
    {
        return $this->alunoService->deleteAluno($id);
    }

    public function createAluno(AlunoPostRequest $request)
    {
        $data = $request->validated();

        $dataEndereco = $data['enderecos'];

        $dataCurso = $data['curso'];

        $aluno = $this->alunoService->createAluno($data);

        if(!$aluno){
            return response()->json(['message' => 'Erro ao criar aluno!'], 400);
        }

        $endereco = $this->enderecoService->createEndereco($dataEndereco);

        $aluno->enderecos()->attach($endereco->id);

        $aluno->load('enderecos');

        $curso = $this->cursoService->createCurso($dataCurso);

        $aluno->cursos()->attach($curso->id);

        $aluno->load('cursos');

        return new AlunoResource($aluno);

    }

    public function updateAluno(AlunoUpdateRequest $request, $id)
{
    $data = $request->validated();
    $dataEndereco = $data['enderecos'];
    $dataCurso = $data['curso'];

    try{
        $aluno = $this->alunoService->updateAluno($data, $id);

        if (!$aluno) {
            return response()->json(['message' => 'Erro ao atualizar os dados do aluno!'], 400);
        }

        if($dataEndereco){
            $endereco = $this->enderecoService->updateEndereco($dataEndereco, $aluno->enderecos->first()->id);
        }

        if($dataCurso){
            $curso = $this->cursoService->updateCurso($dataCurso, $aluno->cursos->first()->id);
        }


        $aluno->load('enderecos', 'cursos');

        return response()->json(new AlunoResource($aluno), 200);

    }catch(\Exception $e){
        return response()->json(['message' => $e->getMessage()], 400);
    }
}


}
