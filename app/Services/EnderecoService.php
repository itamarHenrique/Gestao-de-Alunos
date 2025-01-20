<?php

namespace App\Services;

use App\Models\Aluno;
use App\Models\Endereco;

class EnderecoService{

    private $endereco;

    public function __construct(Endereco $endereco) {
        $this->endereco = $endereco;
    }

    public function getAll()
    {
        return Endereco::with('alunos')->get();

    }

    public function getById($id)
    {
        return Endereco::with('alunos')->find($id);
    }

    public function createEndereco($data)
{
    return Endereco::create([
        'rua' => $data['rua'],
        'cep' => $data['cep'],
        'numero_da_casa' => $data['numero_da_casa'],
        'bairro' => $data['bairro'],
    ]);
}


    public function delete($id)
    {
        return Endereco::where('id', $id)->delete();
    }

    public function updateEndereco($data, $id)
    {
        $endereco = Endereco::find($id);

        if (!$endereco) {
            throw new \Exception('Endereço não encontrado');
        }

        if (isset($data['enderecos'])) {
            $data = $data['enderecos'];
        }

        $endereco->update($data);

        return $endereco;
    }



}
