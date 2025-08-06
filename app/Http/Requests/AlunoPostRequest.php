<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $alunoId = $this->route('aluno'); // Usa o {aluno} da rota

        return [
            'primeiro_nome' => ['required', 'string', 'max:100', 'min:3'],
            'sobrenome' => ['required', 'string', 'max:100', 'min:3'],
            'matricula' => ['required', 'string', 'max:10', 'min:7', Rule::unique('alunos', 'matricula')->ignore($alunoId)],
            'email' => ['required', 'email', 'max:244', 'min:8', Rule::unique('alunos', 'email')->ignore($alunoId)],
            'user_status' => ['required', 'string', 'in:' . implode(',', config('constants.user_status'))],
            'celular' => ['required', 'string', 'max:20', 'min:11', Rule::unique('alunos', 'celular')->ignore($alunoId)],
            'unidade_de_ensino' => ['required', 'string', 'min:4'],
            'enderecos' => ['required', 'array'],
            'enderecos.rua' => ['nullable', 'string', 'max:244'],
            'enderecos.cep' => ['nullable', 'string', 'max:10'],
            'enderecos.numero_da_casa' => ['nullable', 'string', 'max:20'],
            'enderecos.bairro' => ['nullable', 'string', 'max:244'],
            'curso' => ['required', 'array'],
            'curso.nome' => ['string', 'required', 'min:3'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
    }



    public function messages()
    {
        return [
            'primeiro_nome.required' => 'O campo nome do aluno é obrigatorio',
            'primeiro_nome.min' => 'O nome do aluno deve ter ao menos três caracteres',
            'sobrenome.required' => 'O campo sobrenome do aluno é obrigatorio',
            'sobrenome.min' => 'O sobrenome do aluno deve ter ao menos três caracteres',
            'matricula.required' => 'O campo matricula é obrigatorio',
            'user_status.required' => 'O campo status do usuario é obrigatorio',
            'celular.required' => 'O campo celular é obrigatorio',
            'celular.min' => 'O campo celular deve ter mais que 11 caracteres',
            'celular.max' => 'O campo celular deve ter menos que 20 caracteres',
            'matricula.min' => 'O RA deve ter ao menos 7 caracteres',
            'email.required' => 'O cmapo email é obrigatorio',
            'email.min' => 'O email deve ter ao menos 8 caracteres',
            'unidade_de_ensino.required' => 'O campo unidade de ensino deve ser obrigatorio',
            'unidade_de_ensino.min' => 'Unidade de ensino deve ter ao menos 4 caracteres',
            'matricula.unique' => 'O Registro do Aluno deve ser unico!',
            'email.unique' => 'O email deve ser unico',
            'enderecos.required' => 'O endereço é obrigatório',
            'enderecos.rua.required' => 'O nome da rua do endereço é obrigatório',
            'password.min' => 'A senha deve ter no minimo 8 caracteres'

        ];
    }
}
