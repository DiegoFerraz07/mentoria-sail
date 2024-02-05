<?php

namespace App\Http\Requests\Type;

use App\Rules\IsLegalAgeRule;
use Illuminate\Foundation\Http\FormRequest;
use DateTime;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TypesAddFormRequest extends FormRequest
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
            'description'=> 'required|string|max:512|min:3',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "É obrigatório enviar um nome",
            'name.string' => "É obrigatório que seja um texto",
            'description.required' => "É obrigatório enviar uma descrição",
            'description.string' => "É obrigatório que a descrição seja um texto",
            'description.max' => "A descrição deve ter no máximo 512 caracteres",
            'description.min' => "A descrição deve ter no mínimo 3 caracteres",
        ];
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
