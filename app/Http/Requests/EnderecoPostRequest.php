<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoPostRequest extends FormRequest
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
        'enderecos' => ['required', 'array'],
        'enderecos.rua' => 'sometimes|string',
        'enderecos.cep' => 'sometimes|string',
        'enderecos.numero_da_casa' => 'sometimes|string',
        'enderecos.bairro' => 'sometimes|string',
    ];
}

}
