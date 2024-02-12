<?php

namespace App\Http\Requests\Client;

use App\Rules\IsLegalAgeRule;
use App\Rules\UpdateExistCPF;
use Illuminate\Foundation\Http\FormRequest;
use DateTime;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientUpdateFormRequest extends FormRequest
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
            'cpf'=> [
                'required',
                'string',
                new UpdateExistCPF($this->id, $this->cpf)
            ],
            'date'=> [
                'required',
                'date',
                new IsLegalAgeRule($this->date),
                ]
        ];
    }

    public function messages()
    {
        return [
            'id.required' => "é obrigatório enviar o id",
            'id.integer' => "é obrigatório que seja um número",
            'name.required' => "É obrigatório enviar um nome",
            'name.string' => "É obrigatório que seja um texto",
            'cpf.required' => "É obrigatório enviar um CPF",
            'cpf.string' => "É obrigatório que o CPF seja um texto",
            'cpf.unique' => "Este CPF já está cadastrado",
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
