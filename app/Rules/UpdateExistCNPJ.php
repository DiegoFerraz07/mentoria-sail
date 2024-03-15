<?php

namespace App\Rules;

use App\Models\Supply;
use App\Repositories\SupplyRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateExistCNPJ implements ValidationRule
{
    protected SupplyRepository $supplyRepository;

    public function __construct(private $id, private $cnpj)
    {
        $this->supplyRepository = new SupplyRepository();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {   
        // id, cnpj
        $bdSupplyCNPJ = $this->supplyRepository->getCNPJById($this->id);
        $requestCNPJ = $this->cnpj;

        if($requestCNPJ !== $bdSupplyCNPJ) {
            // verifica se já existe algum com cnpj cadastrado
            $isOtherCNPJExist = $this->supplyRepository->isOthersCNPJById($this->id, $requestCNPJ);
            if($isOtherCNPJExist) {
                $fail("CNPJ já cadastrado por outro fornecedor!");
            }
        }
    }
}
