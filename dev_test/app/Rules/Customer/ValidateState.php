<?php

namespace App\Rules\Customer;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateState implements ValidationRule
{
    protected array $validStates = [
        'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO',
        'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI',
        'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array(strtoupper($value), $this->validStates)) {
            $fail("O estado é inválido.");
        }
    }
}
