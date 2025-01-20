<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlunoPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'primeiro_nome' => ['required', 'string', 'max:100', 'min:3'],
            'sobrenome' => ['required', 'string', 'max:100', 'min:3'],
            'RA' => ['required', 'string', 'max:40', 'min:7', 'unique:alunos,RA'],
            'email' => ['required', 'email', 'max:244', 'min:8', 'unique:alunos,email'],
            'unidade_de_ensino' => ['required', 'string', 'min:4'],
            'enderecos' => ['required', 'array'],
            'enderecos.rua' => ['nullable', 'string', 'max:244'],
            'enderecos.cep' => ['nullable', 'string', 'max:10'],
            'enderecos.numero_da_casa' => ['nullable', 'string', 'max:20'],
            'enderecos.bairro' => ['nullable', 'string', 'max:244'],
            'curso' => ['required', 'array'],
            'curso.nome' => ['string', 'required']

        ];
    }

    public function messages()
    {
        return [
            'primeiro_nome.required' => 'O campo nome do aluno é obrigatorio',
            'primeiro_nome.min' => 'O nome do aluno deve ter ao menos três caracteres',
            'sobrenome.required' => 'O campo sobrenome do aluno é obrigatorio',
            'sobrenome.min' => 'O sobrenome do aluno deve ter ao menos três caracteres',
            'RA.required' => 'O campo RA é obrigatorio',
            'RA.min' => 'O RA deve ter ao menos 7 caracteres',
            'email.required' => 'O cmapo email é obrigatorio',
            'email.min' => 'O email deve ter ao menos 8 caracteres',
            'unidade_de_ensino.required' => 'O campo unidade de ensino deve ser obrigatorio',
            'unidade_de_ensino.min' => 'Unidade de ensino deve ter ao menos 4 caracteres',
            'RA.unique' => 'O Registro do Aluno deve ser unico!',
            'email.unique' => 'O email deve ser unico',
            'enderecos.required' => 'O endereço é obrigatório',
            'enderecos.rua.required' => 'O nome da rua do endereço é obrigatório',

        ];
    }
}
