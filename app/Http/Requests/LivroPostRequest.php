<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroPostRequest extends FormRequest
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
            'titulo' => ['required', 'string', 'max:255', 'min:3'],
            'autor' => ['required', 'string', 'max:255'],
            'editora' => ['nullable', 'string', 'max:255'],
            'ano' => ['nullable', 'integer', 'between:1800,' . date('Y')],
            'categoria' => ['nullable', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'quantidade' => ['nullable', 'integer', 'min:1'],
            'arquivo_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'O título do livro é obrigatório.',
            'titulo.min' => 'O título deve ter no mínimo 3 caracteres.',
            'autor.required' => 'O autor é obrigatório.',
            'arquivo_pdf.mimes' => 'O arquivo deve ser um PDF.',
            'arquivo_pdf.max' => 'O arquivo deve ter no máximo 20MB.',
            'quantidade.min' => 'A quantidade deve ser no mínimo 1.',
        ];
    }
}
