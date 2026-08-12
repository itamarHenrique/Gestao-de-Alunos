<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'autor', 'editora', 'ano', 'categoria', 'descricao', 'arquivo_pdf', 'quantidade'];

    protected $hidden = ['pivot'];

    protected $appends = ['disponiveis', 'emprestimos_ativos'];

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_livro', 'livro_id', 'aluno_id')
            ->withPivot('id', 'data_emprestimo', 'data_devolucao')
            ->withTimestamps();
    }

    public function emprestimosAtivos()
    {
        return $this->alunos()->wherePivotNull('data_devolucao');
    }

    public function getEmprestimosAtivosAttribute()
    {
        return $this->emprestimosAtivos()->count();
    }

    public function getDisponiveisAttribute()
    {
        return max(0, $this->quantidade - $this->emprestimos_ativos);
    }
}
