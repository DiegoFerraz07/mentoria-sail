<?php

namespace App\Http\Requests\Product;

use App\Rules\IsLegalAgeRule;
use Illuminate\Foundation\Http\FormRequest;
use DateTime;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductAddFormRequest extends FormRequest
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
            'nome'=> 'required|string',
            'valor'=> 'required|decimal',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => "É obrigatório enviar um nome",
            'nome.string' => "É obrigatório que seja um texto",
            'valor.required' => "É obrigatório enviar um valor",
            'valor.decimal' => "É obrigatório que seja um número decimal",
        ];
    }

    protected function prepareForValidation()
    {
    
    }

    /**
     * failed validation
     */
    protected function failedValidation(Validator $validator)
    {
         
        // Pega as mensagens de erro     
        $error_messages = $validator->errors()->all();

        // Exibe os parâmetros de erro
        throw new HttpResponseException(
        response()->json([
                'success' => false,
                'message' => $error_messages[0],
                'all_messages' => $error_messages,
            ])
        );      

    }

}
