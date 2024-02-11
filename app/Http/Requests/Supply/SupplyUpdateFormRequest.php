<?php

namespace App\Http\Requests\Supply;

use App\Models\Supply;
use App\Rules\UpdateExistCNPJ;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

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
            'cnpj'=> [
                'required',
                'string',
                new UpdateExistCNPJ($this->id, $this->cnpj)
            ]
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
            'cnpj.unique' => "Esse CNPJ já está cadastrado",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Pega as mensagens de erro     
        $errorMessages = $validator->errors()->all();

        // Exibe os parâmetros de erro
        throw new HttpResponseException(
        response()->json([
                'success' => false,
                'message' => $errorMessages[0],
                'all_messages' => $errorMessages,
            ])
        );      
    }
}
