<?php

namespace App\Rules;

use App\Repositories\ClientRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistClientRule implements ValidationRule
{
    protected ClientRepository $clientRepository;

    public function __construct()
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
        $isClient = $this->clientRepository->get($value);
        if(!$isClient) {
            $fail('Fornecedor não encontrado!');
        }
    }
}
