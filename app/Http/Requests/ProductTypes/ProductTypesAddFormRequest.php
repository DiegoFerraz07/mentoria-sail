<?php

namespace App\Http\Requests\ProductTypes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductTypesAddFormRequest extends FormRequest
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
            'type_id'=> 'required|integer',
            'product_id'=> 'required|integer',
        ];
    }

    public function messages()
    {
        return [
           'type_id.required'=> "É obrigatório enviar o id do tipo do produto",
           'type_id.integer'=> "É obrigatório que seja um número inteiro",
           'product_id.required'=> "É obrigatório enviar o id do produto",
           'product_id.integer'=>  "É obrigatório que seja um número inteiro",
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
