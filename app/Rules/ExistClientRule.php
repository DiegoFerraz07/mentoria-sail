<?php

namespace App\Rules;

use App\Repositories\ClientRepository;
use Carbon\Carbon;
use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;

use function Laravel\Prompts\error;

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

        function calcularIdade($value)
        {
            $age = 0;

            $dataNasc = date('Y-m-d', strtotime($value));
            $data = explode('-', $dataNasc);

            $anoNasc    = $data[0];
            $mesNasc    = $data[1];
            $diaNasc    = $data[2];

            $anoAtual   = date("Y");
            $mesAtual   = date("m");
            $diaAtual   = date("d");

            $age = $anoAtual - $anoNasc;

            if ($mesAtual < $mesNasc){
                $age -= 1;
            } elseif ( ($mesAtual == $mesNasc) && ($diaAtual <= $diaNasc) ){
                $age -= 1;
            }

            return $age;
        }


        if(calcularIdade($value)<18){

            $fail('idade não permitida');
        }


    }
}
