<?php

namespace App\Rules\Customer;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCpf implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/(\d)\1{10}/', $value)) {
            $fail("O CPF é inválido.");
            return;
        }

        // Validação dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($c = 0; $c < $t; $c++) {
                $sum += $value[$c] * (($t + 1) - $c);
            }
            $digit = ((10 * $sum) % 11) % 10;
            if ($value[$t] != $digit) {
                $fail("O CPF é inválido.");
                return;
            }
        }
    }
}
