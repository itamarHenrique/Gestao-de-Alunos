<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmprestimoRequest;
use App\Http\Requests\LivroPostRequest;
use App\Http\Requests\LivroUpdateRequest;
use App\Http\Requests\ReservaRequest;
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

    public function reservas()
    {
        $reservas = $this->livroService->reservasPendentes();

        return view('admin.livros.reservas', compact('reservas'));
    }

    public function confirmarReserva($reservaId)
    {
        $confirmada = $this->livroService->confirmarReserva($reservaId);

        if (!$confirmada) {
            return redirect()->route('admin.livros.reservas')->with('error', 'Não foi possível confirmar a reserva.');
        }

        return redirect()->route('admin.livros.reservas')->with('success', 'Reserva confirmada. Empréstimo registrado com sucesso.');
    }

    public function cancelarReservaAdmin($reservaId)
    {
        $cancelada = $this->livroService->cancelarReserva($reservaId);

        if (!$cancelada) {
            return redirect()->route('admin.livros.reservas')->with('error', 'Não foi possível cancelar a reserva.');
        }

        return redirect()->route('admin.livros.reservas')->with('success', 'Reserva cancelada com sucesso.');
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

        $minhaReserva = $this->usuarioAtual() instanceof Aluno
            ? $livro->reservasPendentes()->where('aluno_id', $this->usuarioAtual()->id)->first()
            : null;

        return view('biblioteca.show', compact('livro', 'minhaReserva'));
    }

    public function reservar(ReservaRequest $request)
    {
        $usuario = $this->usuarioAtual();

        if (!$usuario instanceof Aluno) {
            return redirect()->route('biblioteca.index')->with('error', 'Apenas alunos podem reservar livros.');
        }

        $data = $request->validated();

        $reserva = $this->livroService->reservar($usuario->id, $data['livro_id'], $data['data_retirada']);

        if (!$reserva) {
            return redirect()->route('biblioteca.show', $data['livro_id'])->with('error', 'Não foi possível reservar o livro. Verifique a disponibilidade ou se você já possui uma reserva pendente para este livro.');
        }

        return redirect()->route('biblioteca.emprestimos')->with('success', 'Reserva firmada com sucesso! Compareça na data escolhida para retirar o livro.');
    }

    public function cancelarReservaAluno($reservaId)
    {
        $usuario = $this->usuarioAtual();

        if (!$usuario instanceof Aluno) {
            return redirect()->route('biblioteca.index')->with('error', 'Apenas alunos podem cancelar reservas.');
        }

        $cancelada = $this->livroService->cancelarReserva($reservaId, $usuario->id);

        if (!$cancelada) {
            return redirect()->route('biblioteca.emprestimos')->with('error', 'Não foi possível cancelar a reserva.');
        }

        return redirect()->route('biblioteca.emprestimos')->with('success', 'Reserva cancelada com sucesso.');
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
        $usuario = $this->usuarioAtual();

        if ($usuario instanceof Aluno) {
            $emprestimos = $this->livroService->emprestimosDoAluno($usuario->id);
            $reservas = $this->livroService->reservasDoAluno($usuario->id);
        } else {
            $emprestimos = collect();
            $reservas = collect();
        }

        return view('biblioteca.emprestimos', compact('emprestimos', 'reservas'));
    }

    private function usuarioAtual()
    {
        return Auth::guard('aluno')->check()
            ? Auth::guard('aluno')->user()
            : Auth::user();
    }
}
