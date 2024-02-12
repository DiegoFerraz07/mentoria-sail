<?php

namespace App\Rules;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateExistCPF implements ValidationRule
{
    protected ClientRepository $clientRepository;

    public function __construct(private $id, private $cpf)
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
        // id, cpf
        $bdClientCPF = $this->clientRepository->getCPFById($this->id);
        $requestCPF = $this->cpf;

        if($requestCPF !== $bdClientCPF) {
            // verifica se já existe algum com cpf ja cadastrado
            $isOtherCPFExist = $this->clientRepository->isOthersCPFById($this->id, $requestCPF);
            if($isOtherCPFExist) {
                $fail("CPF já cadastrado por outro cliente!");
            }
        }
    }
}
