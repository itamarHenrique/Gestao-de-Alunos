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

        return view('admin.alunos.index', compact('alunos'));
    }

    public function getById($id)
    {
        $aluno = $this->alunoService->getById($id);

        return new AlunoResource($aluno);
    }

        public function deleteAluno($id)
    {
        $deleted = $this->alunoService->deleteAluno($id);

        if ($deleted) {
            return redirect()->route('admin.alunos.index')->with('success', 'Aluno excluído com sucesso.');
        }

        return redirect()->route('admin.alunos.index')->withErrors('Erro ao excluir aluno.');
    }


    public function createAluno(AlunoPostRequest $request)
    {
        $data = $request->validated();
        
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }


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

        return $this->index();

    }
    
        public function create()
    {
        // Buscar dados necessários para popular selects no formulário, se precisar
        $cursos = $this->cursoService->getAll();
        $enderecos = $this->enderecoService->getAll();

        // Retorna a view admin.alunos.create passando os dados
        return view('admin.alunos.create', compact('cursos', 'enderecos'));
    }
        public function edit($id)
    {
        $aluno = Aluno::with('cursos')->findOrFail($id);
        $cursos = Curso::all();

        return view('admin.alunos.edit', compact('aluno', 'cursos'));
    }




    public function updateAluno(AlunoUpdateRequest $request, Aluno $aluno)
    {
        $data = $request->validated();
        $dataEndereco = $data['enderecos'] ?? null;
        $dataCurso = $data['curso'] ?? null;

        try {
            unset($data['enderecos'], $data['curso']);

            $aluno = $this->alunoService->updateAluno($data, $aluno->id);

            if (!$aluno) {
                return redirect()->back()->withErrors(['message' => 'Erro ao atualizar o aluno']);
            }

            if ($dataEndereco) {
                $this->enderecoService->updateEndereco($dataEndereco, $aluno->enderecos->first()->id);
            }

            if ($dataCurso) {
                $this->cursoService->updateCurso($dataCurso, $aluno->cursos->first()->id);
            }

            return redirect()->route('admin.alunos.index')->with('success', 'Aluno atualizado com sucesso.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }




}
