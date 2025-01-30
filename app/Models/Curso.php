<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['nome', 'user_formacao'];

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_curso', 'curso_id', 'aluno_id')->withTimestamps();
    }

}
