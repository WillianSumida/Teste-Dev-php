<?php

namespace App\Services;

use App\Services\CepProviders\CepProviderInterface;
use Illuminate\Support\Facades\Cache;

class CepService
{
    /**
     * @var CepProviderInterface[]
     */
    protected $providers = [];

    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    public function validateCep(string $cep): ?array
    {
        $cacheKey = "cep:$cep";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $data = Cache::remember($cacheKey, now()->addHour(), function () use ($cep) {
            foreach ($this->providers as $provider) {
                $result = $provider->validateCep($cep);
                if ($result) {
                    return $result;
                }
            }
            return null;
        });

        return $data;
    }
}
