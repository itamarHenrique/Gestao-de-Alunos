<?php

namespace App\Services;

use App\Models\Aluno;

class AlunoService
{

    private $aluno;
    private $enderecoService;

    public function __construct(Aluno $aluno, EnderecoService $enderecoService) {
        $this->aluno = $aluno;
        $this->enderecoService = $enderecoService;
    }

    public function getAll()
    {
        return Aluno::with('enderecos')->get();
    }

    public function getById($id)
    {
        return Aluno::with('enderecos')->find($id);
    }

    public function createAluno($data)
    {

        $endereco = isset($data['endereco']) ? $data['endereco'] : null;

        return Aluno::create([
            'primeiro_nome' => $data['primeiro_nome'],
            'sobrenome' => $data['sobrenome'],
            'endereco' => $endereco,
            'RA' => $data['RA'],
            'email' => $data['email'],
            'celular' => $data['celular'],
            'curso' => $data['curso'],
            'unidade_de_ensino' => $data['unidade_de_ensino']
        ]);
    }

    public function deleteAluno($id)
    {
        return Aluno::where('id', $id)->delete();
    }

    public function updateAluno($data, $id)
{
    $aluno = Aluno::find($id);

    if($aluno){
        unset($data['enderecos']);
        unset($data['curso']);
        $aluno->update($data);
    }

    return $aluno;
}


}
