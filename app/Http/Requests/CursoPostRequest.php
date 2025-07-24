<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoPostRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:100', 'min:3', 'unique:cursos,nome'],
            'tipo_formacao' => ['sometimes', 'string', 'in:' . implode(',', config('constants.tipo_formacao', []))],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome do curso é obrigatorio',
            'tipo_formacao.sometimes' => 'O campo tipo de formação é obrigatorio',
        ];


    }
}
