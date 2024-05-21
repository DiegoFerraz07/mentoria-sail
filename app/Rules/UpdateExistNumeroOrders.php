<?php

namespace App\Rules;

use App\Repositories\OrdersRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateExistNumeroOrders implements ValidationRule
{
    protected OrdersRepository $ordersRepository;

    public function __construct(private $id, private $numeroOrder)
    {
        $this->ordersRepository = new OrdersRepository();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {   
        // id, numeroOrder
        $bdNumeroOrder = $this->ordersRepository->getNumeroOrderById($this->id);
        $requestNumeroOrder = $this->numeroOrder;

        if($requestNumeroOrder !== $bdNumeroOrder) {
            // verifica se já existe algum com cnpj cadastrado
            $isOtherNumeroOrderExist = $this->ordersRepository->isOthersNumeroOrderById($this->id, $requestNumeroOrder);
            if($isOtherNumeroOrderExist) {
                $fail("Numero do pedido já cadastrado!");
            }
        }
    }
}
