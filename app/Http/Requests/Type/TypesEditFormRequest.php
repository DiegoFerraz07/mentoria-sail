<?php

namespace App\Http\Requests\Type;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TypesEditFormRequest extends FormRequest
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
            'id' => 'required|integer|exists:types,id',
        ];
    }

    public function prepareforValidation()
    {
        $this->merge([
            'id' => (int) $this->id,
        ]);
    }


    public function messages()
    {
        return [
            'id.required' => "É obrigatório enviar um id",
            'id.integer' => "É obrigatório que seja um número inteiro",
            'id.exists' => "O id enviado não existe",
        ];
    }

    /**
     * Caso a validação falhe, retorna os itens de erro
     * 
     * @return Json
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
            ], 422)
        );
    }
}
