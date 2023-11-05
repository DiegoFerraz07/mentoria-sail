<?php

namespace App\Http\Requests\Client;

use App\Rules\ExistClientRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ClientEditFormRequest extends FormRequest
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
            'id' => [
                'required',
                'integer', /* 'exists:cleintes' */
                new ExistClientRule($this->id)
            ],
        ];
    }


    public function messages()
    {
        return [
            'search.required' => "é obrigatório enviar um nome ou CPF para pesquisar",
            'search.string' => "é obrigatório que seja um texto",
        ];
    }


    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $id = $this->id;

        $this->merge([
            'id' => $id
        ]);
    }


    /**
     * Caso a validação falhe, retorna os itens de erro
     *
     * @return Json
     */
    protected function failedValidation(Validator $validator)
    {
        abort(404);
    }
}
