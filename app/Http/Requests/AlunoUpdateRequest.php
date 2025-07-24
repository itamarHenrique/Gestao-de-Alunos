<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlunoUpdateRequest extends FormRequest
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
        'primeiro_nome' => ['sometimes', 'string', 'max:255', 'min:3'],
        'sobrenome' => ['sometimes', 'string', 'max:255', 'min:3'],
        'RA' => ['sometimes', 'string', 'max:255', 'min:7'],
        'email' => ['sometimes', 'email', 'max:255', 'min:8'],
        'celular' => ['sometimes', 'string', 'max:20', 'min:11'],
        'unidade_de_ensino' => ['sometimes', 'string', 'min:4'],
        'enderecos' => ['sometimes', 'array'],
        'curso' => ['sometimes', 'array'],
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ];
}


    public function messages()
    {
        return [
            'primeiro_nome.min' => 'O nome do aluno deve ter ao menos três caracteres',
            'sobrenome.min' => 'O sobrenome do aluno deve ter ao menos três caracteres',
            'RA.min' => 'O RA deve ter ao menos 7 caracteres',
            'email.min' => 'O email deve ter ao menos 8 caracteres',
            'unidade_de_ensino.min' => 'Unidade de ensino deve ter ao menos 4 caracteres',
            'RA.unique' => 'O Registro do Aluno deve ser unico!',
            'email.unique' => 'O email deve ser unico',
        ];
    }
}
