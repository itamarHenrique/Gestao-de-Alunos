<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
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
            'livro_id' => ['required', 'integer', 'exists:livros,id'],
            'data_retirada' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages()
    {
        return [
            'livro_id.required' => 'Selecione um livro.',
            'livro_id.exists' => 'O livro selecionado não existe.',
            'data_retirada.required' => 'Escolha a data de retirada.',
            'data_retirada.date' => 'Informe uma data válida.',
            'data_retirada.after_or_equal' => 'A data de retirada deve ser hoje ou uma data futura.',
        ];
    }
}
