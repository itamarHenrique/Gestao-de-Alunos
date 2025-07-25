<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Endereco extends Authenticatable
{
    Use Notifiable, HasFactory;

    protected $fillable = ['rua', 'cep', 'numero_da_casa', 'bairro'];

    protected $endereco = 'enderecos';

    protected $hidden = ['pivot', 'alunos'];

    protected $appends = ['aluno'];

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_endereco', 'endereco_id', 'aluno_id')
            ->withTimestamps();
    }

    public function getAlunoAttribute()
    {
        return $this->alunos;
    }


}
