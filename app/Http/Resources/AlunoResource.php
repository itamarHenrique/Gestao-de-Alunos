<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlunoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_status' => $this->user_status,
            'primeiro_nome' => $this->primeiro_nome,
            'sobrenome' => $this->sobrenome,
            'nome_completo' => "{$this->primeiro_nome} {$this->sobrenome}",
            'endereços' =>$this->enderecos->map(function($endereco) {
                return [
                    'id' => $endereco->id,
                    'nome da rua' => $endereco->rua,
                    'cep' => $endereco->cep,
                    'numero da casa' => $endereco->numero_da_casa,
                    'bairro' => $endereco->bairro
                ];
            }),
            'curso' => $this->cursos->map(function($curso) {
                return [
                'id' => $curso->id,
                'nome do curso' => $curso->nome,
                'tipo do curso' => $curso->formacao
                ];
            }),
            'email' => $this->email,
            'celular' => $this->celular,
            'RA' => $this->RA,
            'unidade_de_ensino' => $this->unidade_de_ensino
        ];
    }
}
