<?php

namespace App\Http\Requests\Type;

use Illuminate\Foundation\Http\FormRequest;

class TypesUpdateFormRequest extends FormRequest
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
            'description'=> 'required|string|max:512|min:3',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => "é obrigatório enviar o id",
            'id.integer' => "é obrigatório que seja um número",
            'name.required' => "é obrigatório enviar um nome",
            'name.string' => "é obrigatório que seja um texto",
            'description.required' => "é obrigatório enviar uma descrição",
            'description.string' => "é obrigatório que a descrição seja um texto",
            'description.max' => "A descrição deve ter no máximo 512 caracteres",
            'description.min' => "A descrição deve ter no mínimo 3 caracteres"
        ];
    }
}
