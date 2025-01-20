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

    public function updateCurso($data, $id)
    {
        $curso = Curso::find($id);

        if(!$curso){
            throw new \Exception('Curso não encontrado');
        }

        if(isset($data['curso'])){
            $data = $data['curso'];
        }

        $curso->update($data);

        return $curso;
    }

    public function deleteById($id)
    {
        return Curso::where('id', $id)->delete();
    }
}
