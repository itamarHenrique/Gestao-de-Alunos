<?php

namespace App\Models;

use App\Http\Requests\AlunoPostRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;


    protected $fillable = ['primeiro_nome', 'sobrenome','enderecos' , 'RA','email','unidade_de_ensino', 'user_status', 'user_formacao'];

    protected $aluno = 'alunos';

    protected $hidden = ['pivot'];

    protected $appends = ['nome completo'];


    public function enderecos()
    {
        return $this->belongsToMany(Endereco::class, 'aluno_endereco', 'aluno_id', 'endereco_id')->withTimestamps();
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'aluno_curso', 'aluno_id', 'curso_id')->withTimestamps();
    }


public function getNomeCompletoAttribute()
{
    return $this->primeiro_nome . ' ' . $this->sobrenome;
}


}
