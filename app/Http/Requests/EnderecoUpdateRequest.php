<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'rua' => 'sometimes|string|max:255',
            'cep' => 'sometimes|string|max:20',
            'numero_da_casa' => 'sometimes|string|max:10',
            'bairro' => 'sometimes|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'rua.string' => 'A rua deve ser uma string.',
            'cep.string' => 'O CEP deve ser uma string.',
            'numero_da_casa.string' => 'O número da casa deve ser uma string.',
            'bairro.string' => 'O bairro deve ser uma string.',
        ];
    }
}
