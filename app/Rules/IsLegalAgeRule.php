<?php

namespace App\Rules;

use App\Models\Client;
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
        $age = Carbon::parse($value)->age;
        if($age < Client::LEGAL_AGE ){
            $fail('Idade não permitidade');
        }
    }
}
