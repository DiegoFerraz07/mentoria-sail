<?php

namespace App\Rules;

use App\Repositories\ClientRepository;
use Carbon\Carbon;
use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;

use function Laravel\Prompts\error;

class IsLegalAgeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $age = Carbon::parse($value) -> age;

        if($age < 18 ){
            $fail('Idade não permitidade');
        }
    }
}
