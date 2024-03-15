<?php

namespace App\Rules;

use App\Repositories\ProductRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistProductRule implements ValidationRule
{
    protected ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isProduct = $this->productRepository->get($value);
        if(!$isProduct) {
            $fail('Produto não encontrado!');
        }
    }
}
