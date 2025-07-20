<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'name'         => $this->faker->name,
            'email'        => $this->faker->unique()->safeEmail,
            'cpf'          => $this->faker->numerify('###########'),
            'phone'        => $this->faker->phoneNumber,
            'cep'          => $this->faker->numerify('########'),
            'street'       => $this->faker->streetName,
            'neighborhood' => $this->faker->citySuffix,
            'city'         => $this->faker->city,
            'state'        => $this->faker->stateAbbr,
        ];
    }
}
