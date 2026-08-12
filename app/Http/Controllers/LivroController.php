<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmprestimoRequest;
use App\Http\Requests\LivroPostRequest;
use App\Http\Requests\LivroUpdateRequest;
use App\Models\Aluno;
use App\Models\Livro;
use App\Services\LivroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LivroController extends Controller
{
    private $livroService;

    public function __construct(LivroService $livroService)
    {
        $this->livroService = $livroService;
    }

    // ===================== ADMIN =====================

    public function index()
    {
        $livros = $this->livroService->getAll();

        return view('admin.livros.index', compact('livros'));
    }

    public function create()
    {
        return view('admin.livros.create');
    }

    public function store(LivroPostRequest $request)
    {
        $data = $request->validated();

        $livro = $this->livroService->createLivro($data);

        if (!$livro) {
            return redirect()->back()->with('error', 'Erro ao criar o livro.');
        }

        return redirect()->route('admin.livros.index')->with('success', 'Livro cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $livro = $this->livroService->getById($id);

        if (!$livro) {
            return redirect()->route('admin.livros.index')->with('error', 'Livro não encontrado.');
        }

        return view('admin.livros.edit', compact('livro'));
    }

    public function update(LivroUpdateRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $livro = $this->livroService->updateLivro($id, $data);

            return redirect()->route('admin.livros.index')->with('success', 'Livro atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $deletado = $this->livroService->deleteLivro($id);

        if (!$deletado) {
            return redirect()->back()->with('error', 'Erro ao excluir o livro.');
        }

        return redirect()->route('admin.livros.index')->with('success', 'Livro excluído com sucesso.');
    }

    public function showEmprestar($id)
    {
        $livro = $this->livroService->getById($id);

        if (!$livro) {
            return redirect()->route('admin.livros.index')->with('error', 'Livro não encontrado.');
        }

        $alunos = Aluno::orderBy('primeiro_nome')->get();

        return view('admin.livros.emprestar', compact('livro', 'alunos'));
    }

    public function emprestar(EmprestimoRequest $request)
    {
        $data = $request->validated();

        $emprestado = $this->livroService->emprestar($data['aluno_id'], $data['livro_id']);

        if (!$emprestado) {
            return redirect()->route('admin.livros.index')->with('error', 'Não foi possível realizar o empréstimo. Verifique a disponibilidade do livro.');
        }

        return redirect()->route('admin.livros.index')->with('success', 'Empréstimo realizado com sucesso.');
    }

    public function emprestimos()
    {
        $emprestimos = $this->livroService->emprestimosAtivos();

        return view('admin.livros.emprestimos', compact('emprestimos'));
    }

    public function devolver(Request $request, $emprestimoId)
    {
        $emprestimo = \DB::table('aluno_livro')->find($emprestimoId);

        if (!$emprestimo) {
            return redirect()->back()->with('error', 'Empréstimo não encontrado.');
        }

        $devolvido = $this->livroService->devolver($emprestimo->aluno_id, $emprestimo->livro_id);

        if (!$devolvido) {
            return redirect()->back()->with('error', 'Erro ao devolver o livro.');
        }

        return redirect()->route('admin.livros.emprestimos')->with('success', 'Livro devolvido com sucesso.');
    }

    // ===================== PÁGINA PÚBLICA =====================

    public function catalogo(Request $request)
    {
        $termo = $request->query('busca');

        $livros = $termo
            ? $this->livroService->buscar($termo)
            : $this->livroService->getAll();

        return view('biblioteca.index', compact('livros', 'termo'));
    }

    public function show($id)
    {
        $livro = $this->livroService->getById($id);

        if (!$livro) {
            abort(404);
        }

        return view('biblioteca.show', compact('livro'));
    }

    public function baixar($id)
    {
        $livro = $this->livroService->getById($id);

        if (!$livro || !$livro->arquivo_pdf) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($livro->arquivo_pdf)) {
            abort(404);
        }

        return Storage::disk('public')->download($livro->arquivo_pdf, $livro->titulo . '.pdf');
    }

    public function meusEmprestimos()
    {
        $usuario = Auth::guard('aluno')->check()
            ? Auth::guard('aluno')->user()
            : Auth::user();

        if ($usuario instanceof Aluno) {
            $emprestimos = $this->livroService->emprestimosDoAluno($usuario->id);
        } else {
            $emprestimos = collect();
        }

        return view('biblioteca.emprestimos', compact('emprestimos'));
    }
}
