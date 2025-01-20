<?php

namespace App\Services;

use App\Models\Curso;

class CursoService
{


    private $curso;

    public function __construct(Curso $curso)
    {
        $this->curso = $curso;
    }

    public function getAll()
    {
        return collect($this->curso->all());

    }
    public function getAllWithAlunos()
    {
        return Curso::with('alunos')->get();
    }

    public function getById($id)
    {
        return Curso::with('alunos')->find($id);
    }

    public function createCurso($data)
    {
        return Curso::create([
            'nome' => $data['nome']
        ]);
    }

    public function deleteById($id)
    {
        return Curso::where('id', $id)->delete();
    }
}
