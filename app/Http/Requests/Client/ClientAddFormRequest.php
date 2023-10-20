<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use DateTime;

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
            'date'=> 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "é obrigatório enviar um nome",
            'name.string' => "é obrigatório que seja um texto",
            'cpf.required' => "é obrigatório enviar um cnpj",
            'cpf.string' => "é obrigatório que o cnpj seja um texto",
        ];
    }

    protected function prepareForValidation()
    {
        $date = DateTime::createFromFormat('d/m/Y', $this->date)
            ->format("Y-m-d");
        $this->merge([
            'date' => $date
        ]);
    }


}
