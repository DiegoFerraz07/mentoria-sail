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
            'valor'=> 'required|decimal:2',
            'types' => 'required|array',
            'brandId' => 'required|integer',
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
            'brandId.required' => "É obrigatório enviar uma marca",
            'brandId.integer' => "É obrigatório enviar um numero inteiro",
        ];
    }

    protected function prepareForValidation()
    {
        $valor = $this->valor;
        //22.300,00
        if(strpos($this->valor, ',') !== false) {
            $valor = trim(str_replace('R$', '', $this->valor));
             // remove o ponto
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        }

        if(is_array($this->types)) {
            if($this->types[0]['id']) {
                $this->merge([
                    'types' => array_column($this->types, 'id'),
                ]);
            }
        }

        $this->merge([
            'valor' => number_format($valor, 2, '.', '')
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
