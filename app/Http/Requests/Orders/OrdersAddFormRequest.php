<?php

namespace App\Http\Requests\Orders;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrdersAddFormRequest extends FormRequest
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
        $ruleCPF = $this->cpfClient ? 'required|string' : 'string';
        $ruleCNPJ = $this->cnpjClient ? 'required|string' : 'string';
        return [
            'numeroOrder'=> 'required|string',
            'descriptionOrder' => 'required|string',
            'taxOrder' => 'required|decimal:2',
            'icmsOrder' => 'required|decimal:2',
            'totalValueOrder' => 'required|decimal:2',
            'obsOrder' => 'required|string',
            'nameSupply' => 'required|string',
            'cnpjSupply' => 'required|string',
            'nameClient' => 'required|string',
            'cpfClient' => $ruleCPF,
            'cnpjClient' => $ruleCNPJ,
            'addressClient' => 'required|array:street,number,complement,neighborhood,city,state,zipcode',
            'ordersItens' => 'required|array:id,nome,valor,quantity,description,unitValue,totalValue,taxValue,icmsValue'
        ];
    }

    public function messages()
    {
        return [
            'numeroOrder.required' => "É obrigatório enviar o numero da Order",
            'numeroOrder.string' => "É obrigatório que seja um texto",
            'descriptionOrder.required' => "É obrigatório enviar a descrição",
            'descriptionOrder.string' => "É obrigatório que seja um texto",
            'taxOrder.required' => "É obrigatório enviar o valor do imposto",
            'taxOrder.string' => "É obrigatório que seja um decimal",
            'icmsOrder.required' => "É obrigatório enviar o valor o icms",
            'icmsOrder.string' => "É obrigatório que seja um decimal",
            'totalValueOrder.required' => "É obrigatório enviar o valor total",
            'totalValueOrder.string' => "É obrigatório que seja um decimal",
            'obsOrder.required' => "É obrigatório enviar uma abservação",
            'obsOrder.string' => "É obrigatório que seja um texto",
            'nameSupply.required' => "É obrigatório enviar o nome do fornecedor",
            'nameSupply.string' => "É obrigatório que seja um texto",
            'cnpjSupply.required' => "É obrigatório enviar o cnpj do fornecedor",
            'cnpjSupply.string' => "É obrigatório que seja um texto",
            'nameClient.required' => "É obrigatório enviar o nome do cliente",
            'nameClient.string' => "É obrigatório que seja um texto",
            'cpfClient.required' => "É obrigatório enviar o cpf do cliente",
            'cpfClient.string' => "É obrigatório que seja um texto",
            'cnpjClient.required' => "É obrigatório enviar o cnpj do cliente",
            'cnpjClient.string' => "É obrigatório que seja um texto",
            'addressClient.required' => "É obrigatório enviar um endereço",
            'addressClient.array' => "É obrigatório que o endereço seja um array",
            'addressClient.street' => 'É obrigatório enviar a rua',
            'addressClient.number' => 'É obrigatório enviar o número',
            'addressClient.complement' => 'É obrigatório enviar o complemento',
            'addressClient.neighborhood' => 'É obrigatório enviar o bairro',
            'addressClient.city' => 'É obrigatório enviar a cidade',
            'addressClient.state' => 'É obrigatório enviar o estado',
            'addressClient.zipcode' => 'É obrigatório enviar o CEP',
            'ordersItens.required' => "É obrigatório enviar um endereço",
            'ordersItens.array' => "É obrigatório que o endereço seja um array",
            'ordersItens.id' => 'É obrigatório um id',
            'ordersItens.valor' => 'É obrigatório enviar o valor',
            'ordersItens.amount' => 'É obrigatório enviar a quantidade',
            'ordersItens.descripitiom' => 'É obrigatório enviar a descrição do produto',
            'ordersItens.unitValue' => 'É obrigatório enviar o valor de cada unidade',
            'ordersItens.totalValue' => 'É obrigatório enviar o valor total',
            'ordersItens.taxValue' => 'É obrigatório enviar o valor do imposto',
            'ordersItens.icmsValue' => 'É obrigatório enviar o valor do icms',
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
