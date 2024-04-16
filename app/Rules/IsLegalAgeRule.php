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

    public function __construct(private string $date, private bool $isCPF)
    {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $age = Carbon::parse($this->date)->age;
        if($this->isCPF && $age < Client::LEGAL_AGE ){
            $fail('Idade não permitida');
        }
    }
}
