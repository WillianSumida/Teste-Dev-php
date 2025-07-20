<?php
namespace App\Services\Cep;

use App\Services\Interfaces\CepInterface;
use Illuminate\Support\Facades\Http;

class Viacep implements CepInterface
{
    public function validateCep(string $cep): ?array
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->successful()) {
            $data = $response->json();
            if (!isset($data['erro'])) {
                return $data;
            }
        }

        return null;
    }
}
