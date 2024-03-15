<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class BrandFormRequest extends FormRequest
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
            'search' => 'required|string|min:3'
        ];
    }


    public function messages()
    {
        return [
            'search.string' => "é obrigatório que seja um texto",
            'search.min' => "é obrigatório que tenha no mínimo 3 caracteres"
        ];
    }


    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $search = trim($this->search);

        $this->merge([
            'search' => $search
        ]);
    }


    /**
     * Caso a validação falhe, retorna os itens de erro
     *
     * @return Json
     */
    /*protected function failedValidation(Validator $validator)
    {

        // Pega as mensagens de erro
        $error_messages = $validator->errors()->all();

        // Exibe os parâmetros de erro
        throw new HttpResponseException(
        response()->json(
            [
                'success' => false,
                'error' => $error_messages[0],
                'error_code' => 404,
                'error_messages' => $error_messages,
            ]
        ));
    }  */
}
