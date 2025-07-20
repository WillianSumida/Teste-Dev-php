<?php
namespace App\Services\Cep;

use App\Services\Interfaces\CepInterface;
use Illuminate\Support\Facades\Http;

class BrasilApi implements CepInterface
{
    public function validateCep(string $cep): ?array
    {
        $response = Http::get("https://brasilapi.com.br/api/cep/v1/{$cep}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
