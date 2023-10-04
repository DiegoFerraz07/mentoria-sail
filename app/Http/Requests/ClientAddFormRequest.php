<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;

class ClientAddFormRequest extends FormRequest
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
            'name'=> 'required|string',
            'cpf'=> 'required|string',
            'data'=> 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "é obrigatório enviar um nome",
            'name.string' => "é obrigatório que seja um texto",
            'cpf.required' => "é obrigatório enviar um cnpj",
            'cpf.string' => "é obrigatório que o cnpj seja um texto",
            'data.required' => "é obrigatório enviar um data",
            'data.string' => "é obrigatório que seja uma data",
        ];
    }
}
