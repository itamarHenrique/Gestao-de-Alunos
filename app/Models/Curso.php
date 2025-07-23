<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Curso extends Authenticatable
{

    Use Notifiable, HasFactory;
    protected $fillable = ['nome', 'formacao'];

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_curso', 'curso_id', 'aluno_id')->withTimestamps();
    }

}
