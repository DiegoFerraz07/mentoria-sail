<?php

namespace App\Rules;

use App\Repositories\SupplyRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistSupplyRule implements ValidationRule
{
    protected SupplyRepository $supplyRepository;

    public function __construct()
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
        $isSupply = $this->supplyRepository->get($value);
        if(!$isSupply) {
            $fail('Fornecedor não encontrado!');
        }
    }
}
