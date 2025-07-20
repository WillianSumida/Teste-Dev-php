<?php
namespace App\Services\Interfaces;

interface CepInterface
{
    public function validateCep(string $cep): ?array;
}
