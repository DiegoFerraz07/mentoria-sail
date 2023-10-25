<?php

namespace App\Http\Requests\Supply;

use App\Models\Supply;
use Illuminate\Foundation\Http\FormRequest;

class SupplyUpdateFormRequest extends FormRequest
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
            'id'=> 'required|integer',
            'name'=> 'required|string',
            'cnpj'=> 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => "é obrigatório enviar o id",
            'id.integer' => "é obrigatório que seja um número",
            'name.required' => "é obrigatório enviar um nome",
            'name.string' => "é obrigatório que seja um texto",
            'cnpj.required' => "é obrigatório enviar um cnpj",
            'cnpj.string' => "é obrigatório que o cnpj seja um texto",
        ];
    }
}
