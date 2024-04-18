<?php

namespace App\Http\Requests\Client;

use App\Rules\IsLegalAgeRule;
use Illuminate\Foundation\Http\FormRequest;
use DateTime;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientAddFormRequest extends FormRequest
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
        $ruleCPF = $this->cpf ? 'required|string|unique:cliente,cpf' : 'string';
        $ruleCNPJ = $this->cnpj ? 'required|string|unique:cliente,cnpj' : 'string';
        $isCPF = $this->cpf ? true : false;
        $ruleDate = $this->date && $isCPF
            ? [
                'required',
                'date',
                new IsLegalAgeRule($this->date, $isCPF),
            ]
            : 'required|date';
        return [
            'name'=> 'required|string',
            'email'=> 'required|email|unique:cliente,email',
            'cpf'=> $ruleCPF,
            'cnpj'=> $ruleCNPJ,
            'date'=> $ruleDate,
            'address' => 'required|array:street,number,complement,neighborhood,city,state,zipcode',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "É obrigatório enviar um nome",
            'name.string' => "É obrigatório que seja um texto",
            'email.required' => "É obrigatório enviar um email",
            'email.email' => "É obrigatório que o email seja válido",
            'email.unique' => "Este email já está cadastrado",
            'cpf.required' => "É obrigatório enviar um CPF",
            'cpf.string' => "É obrigatório que o CPF seja um texto",
            'cpf.unique' => "Este CPF já está cadastrado",
            'cnpj.required' => "É obrigatório enviar um CNPJ",
            'cnpj.string' => "É obrigatório que o CNPJ seja um texto",
            'cnpj.unique' => "Este CNPJ já está cadastrado",
            'date.required' => "É obrigatório enviar uma data",
            'date.date' => "É obrigatório que a data seja válida",
            'address.required' => "É obrigatório enviar um endereço",
            'address.array' => "É obrigatório que o endereço seja um array",
            'address.street' => 'É obrigatório enviar a rua',
            'address.number' => 'É obrigatório enviar o número',
            'address.complement' => 'É obrigatório enviar o complemento',
            'address.neighborhood' => 'É obrigatório enviar o bairro',
            'address.city' => 'É obrigatório enviar a cidade',
            'address.state' => 'É obrigatório enviar o estado',
            'address.zipcode' => 'É obrigatório enviar o CEP',
        ];
    }

    protected function prepareForValidation()
    {
        $date = DateTime::createFromFormat('d/m/Y', $this->date)
            ->format("Y-m-d");
        
        $this->merge([
            'date' => $date
        ]);

        if($this->isCNPJ) {
            $this->merge([
                'cnpj' => $this->cnpj,
                'cpf' => ''
            ]);
        } else {
            $this->merge([
                'cnpj' => '',
                'cpf' => $this->cpf
            ]);
        }

        
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
