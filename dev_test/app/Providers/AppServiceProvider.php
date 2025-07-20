<?php

namespace App\Providers;

use App\Repositories\Customers\CustomerRepository;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Services\Cep\BrasilApi;
use App\Services\Cep\Viacep;
use App\Services\CepService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        //modulo para suportar outras apis de ceps
        $this->app->singleton(CepService::class, function ($app) {
            return new CepService([
                new BrasilApi(),
                new Viacep(),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
