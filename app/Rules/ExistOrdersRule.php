<?php

namespace App\Rules;

use App\Repositories\OrdersRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistOrderstRule implements ValidationRule
{
    protected OrdersRepository $ordersRepository;

    public function __construct()
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
        $isOrders = $this->ordersRepository->get($value);
        if(!$isOrders) {
            $fail('Pedido não encontrado!');
        }
    }
}
