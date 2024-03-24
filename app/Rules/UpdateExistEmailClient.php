<?php

namespace App\Rules;

use App\Models\Supply;
use App\Repositories\ClientRepository;
use App\Repositories\SupplyRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateExistEmailClient implements ValidationRule
{
    protected ClientRepository $clientRepository;

    public function __construct(private $id, private $email)
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
        $bdClienEmail = $this->clientRepository->getEmailById($this->id);
        $requestEmail = $this->email;

        if($requestEmail !== $bdClienEmail) {
            // verifica se já existe algum com cnpj cadastrado
            $isOtherEmailExist = $this->clientRepository->isOthersEmailById($this->id, $requestEmail);
            if($isOtherEmailExist) {
                $fail("Email já cadastrado por outro Cliente!");
            }
        }
    }
}
