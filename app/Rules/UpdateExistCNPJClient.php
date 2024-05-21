<?php

namespace App\Rules;


use App\Repositories\ClientRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateExistCNPJClient implements ValidationRule
{
    protected ClientRepository $clientRepository;

    public function __construct(private $id, private $cnpj)
    {
        $this->clientRepository = new ClientRepository();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {   
        // id, cnpj
        $bdClientCNPJ = $this->clientRepository->getCNPJById($this->id);
        $requestCNPJ = $this->cnpj;

        if($requestCNPJ !== $bdClientCNPJ) {
            // verifica se já existe algum com cnpj cadastrado
            $isOtherCNPJExist = $this->clientRepository->isOthersCNPJById($this->id, $requestCNPJ);
            if($isOtherCNPJExist) {
                $fail("CNPJ já cadastrado por outro fornecedor!");
            }
        }
    }
}
