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
            'nome' => ['required', 'string', 'max:100', 'min:3'],
            'user_formacao' => ['required', 'string', 'in:' . implode(',', config('constants.user_formacao'))],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome do curso é obrigatorio',
            'user_formacao.required' => 'O campo formação do usuario é obrigatorio',
        ];


    }
}
