<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmprestimoRequest extends FormRequest
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
            'aluno_id' => ['required', 'integer', 'exists:alunos,id'],
            'livro_id' => ['required', 'integer', 'exists:livros,id'],
        ];
    }

    public function messages()
    {
        return [
            'aluno_id.required' => 'Selecione um aluno.',
            'aluno_id.exists' => 'O aluno selecionado não existe.',
            'livro_id.required' => 'Selecione um livro.',
            'livro_id.exists' => 'O livro selecionado não existe.',
        ];
    }
}
