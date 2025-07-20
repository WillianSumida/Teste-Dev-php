<?php

namespace App\Rules\Customer;

use App\Services\CepService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCep implements ValidationRule
{
    protected CepService $cepService;
    protected string $errorMessage = 'CEP inválido ou não encontrado.';

    public function __construct(CepService $cepService)
    {
        $this->cepService = $cepService;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cepData = $this->cepService->validateCep($value);

        if (!$cepData) {
            $fail($this->errorMessage);
        }
    }
}
