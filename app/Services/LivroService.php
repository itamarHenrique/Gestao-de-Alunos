<?php

namespace App\Services;

use App\Models\Aluno;
use App\Models\Livro;
use App\Models\Reserva;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LivroService
{
    private $livro;

    public function __construct(Livro $livro)
    {
        $this->livro = $livro;
    }

    public function getAll()
    {
        return Livro::orderBy('titulo')->paginate(10);
    }

    public function getById($id)
    {
        return Livro::find($id);
    }

    public function buscar($termo)
    {
        return Livro::where('titulo', 'like', "%{$termo}%")
            ->orWhere('autor', 'like', "%{$termo}%")
            ->orWhere('categoria', 'like', "%{$termo}%")
            ->orderBy('titulo')
            ->paginate(12);
    }

    public function createLivro($data)
    {
        if (isset($data['arquivo_pdf']) && $data['arquivo_pdf']) {
            $data['arquivo_pdf'] = $data['arquivo_pdf']->store('livros', 'public');
        }

        return Livro::create($data);
    }

    public function updateLivro($id, $data)
    {
        $livro = Livro::find($id);

        if (!$livro) {
            throw new \Exception('Livro não encontrado');
        }

        if (isset($data['arquivo_pdf']) && $data['arquivo_pdf']) {
            if ($livro->arquivo_pdf) {
                Storage::disk('public')->delete($livro->arquivo_pdf);
            }
            $data['arquivo_pdf'] = $data['arquivo_pdf']->store('livros', 'public');
        } else {
            unset($data['arquivo_pdf']);
        }

        $livro->update($data);

        return $livro;
    }

    public function deleteLivro($id)
    {
        $livro = Livro::find($id);

        if (!$livro) {
            return false;
        }

        if ($livro->arquivo_pdf) {
            Storage::disk('public')->delete($livro->arquivo_pdf);
        }

        return $livro->delete();
    }

    public function emprestar($alunoId, $livroId)
    {
        $livro = Livro::find($livroId);

        if (!$livro) {
            return false;
        }

        if ($livro->disponiveis <= 0) {
            return false;
        }

        $livro->alunos()->attach($alunoId, ['data_emprestimo' => now()]);

        return true;
    }

    public function devolver($alunoId, $livroId)
    {
        $livro = Livro::find($livroId);

        if (!$livro) {
            return false;
        }

        $emprestimo = $livro->alunos()
            ->where('aluno_id', $alunoId)
            ->wherePivotNull('data_devolucao')
            ->first();

        if (!$emprestimo) {
            return false;
        }

        DB::table('aluno_livro')
            ->where('id', $emprestimo->pivot->id)
            ->update(['data_devolucao' => now()]);

        return true;
    }

    public function emprestimosAtivos()
    {
        return DB::table('aluno_livro')
            ->join('alunos', 'alunos.id', '=', 'aluno_livro.aluno_id')
            ->join('livros', 'livros.id', '=', 'aluno_livro.livro_id')
            ->whereNull('aluno_livro.data_devolucao')
            ->select(
                'aluno_livro.id',
                'aluno_livro.data_emprestimo',
                'alunos.id as aluno_id',
                DB::raw("CONCAT(alunos.primeiro_nome, ' ', alunos.sobrenome) as aluno_nome"),
                'livros.id as livro_id',
                'livros.titulo as livro_titulo'
            )
            ->orderBy('aluno_livro.data_emprestimo', 'desc')
            ->paginate(10);
    }

    public function emprestimosDoAluno($alunoId)
    {
        return Aluno::find($alunoId)?->livros()
            ->orderBy('aluno_livro.data_emprestimo', 'desc')
            ->get();
    }

    public function reservar($alunoId, $livroId, $dataRetirada)
    {
        $livro = Livro::find($livroId);

        if (!$livro) {
            return false;
        }

        if ($livro->disponiveis <= 0) {
            return false;
        }

        $jaReservado = Reserva::where('aluno_id', $alunoId)
            ->where('livro_id', $livroId)
            ->where('status', Reserva::STATUS_PENDENTE)
            ->exists();

        if ($jaReservado) {
            return false;
        }

        return Reserva::create([
            'aluno_id' => $alunoId,
            'livro_id' => $livroId,
            'data_retirada' => $dataRetirada,
            'status' => Reserva::STATUS_PENDENTE,
        ]);
    }

    public function reservasPendentes()
    {
        return DB::table('reservas')
            ->join('alunos', 'alunos.id', '=', 'reservas.aluno_id')
            ->join('livros', 'livros.id', '=', 'reservas.livro_id')
            ->where('reservas.status', Reserva::STATUS_PENDENTE)
            ->select(
                'reservas.id',
                'reservas.data_retirada',
                'reservas.status',
                'alunos.id as aluno_id',
                DB::raw("CONCAT(alunos.primeiro_nome, ' ', alunos.sobrenome) as aluno_nome"),
                'livros.id as livro_id',
                'livros.titulo as livro_titulo'
            )
            ->orderBy('reservas.data_retirada', 'asc')
            ->paginate(10);
    }

    public function confirmarReserva($reservaId)
    {
        $reserva = Reserva::find($reservaId);

        if (!$reserva || $reserva->status !== Reserva::STATUS_PENDENTE) {
            return false;
        }

        $livro = Livro::find($reserva->livro_id);

        if (!$livro) {
            return false;
        }

        DB::transaction(function () use ($reserva, $livro) {
            $livro->alunos()->attach($reserva->aluno_id, ['data_emprestimo' => now()]);

            $reserva->update(['status' => Reserva::STATUS_CONFIRMADA]);
        });

        return true;
    }

    public function cancelarReserva($reservaId, $alunoId = null)
    {
        $reserva = Reserva::find($reservaId);

        if (!$reserva || $reserva->status !== Reserva::STATUS_PENDENTE) {
            return false;
        }

        if ($alunoId !== null && $reserva->aluno_id !== $alunoId) {
            return false;
        }

        return $reserva->update(['status' => Reserva::STATUS_CANCELADA]);
    }

    public function reservasDoAluno($alunoId)
    {
        return Reserva::with('livro')
            ->where('aluno_id', $alunoId)
            ->orderBy('data_retirada', 'desc')
            ->get();
    }
}
