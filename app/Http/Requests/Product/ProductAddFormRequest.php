<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
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
            'types' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => "É obrigatório enviar um nome",
            'nome.string' => "É obrigatório que seja um texto",
            'valor.required' => "É obrigatório enviar um valor",
            'valor.decimal' => "É obrigatório que seja um número decimal",
            'types.required' => "É obrigatório enviar um tipo",
            'types.array' => "É obrigatório que seja um array",
        ];
    }

    protected function prepareForValidation()
    {
        //TODO: remover mascara e deixar com padrão americano para salvar no banco
        // TODO: 10.000,12 => 10000.12 
        // TODO: remover cifra RS$ US$ 
        $valor = str_replace('R$', '', $this->valor); // remove o ponto
        $valor = setlocale(LC_MONETARY, 'en_US');
        $this->merge([
            'valor' => $valor
        ]);
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
