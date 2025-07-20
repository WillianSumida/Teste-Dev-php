<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Laravel\Sanctum\Sanctum;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    protected function validPayload(array $overrides = [])
    {
        return array_merge([
            'name'         => 'Teste Do Dev',
            'email'        => 'teste_dev@teste.com',
            'cpf'          => '37815670016',
            'phone'        => '11999999999',
            'cep'          => '65074247',
            'street'       => 'Rua Domicio Cassiano Almeida',
            'neighborhood' => 'São João',
            'city'         => 'Quixadá',
            'state'        => 'CE'
        ], $overrides);
    }

    public function test_create_customer()
    {
        $this->authenticate();

        $payload = $this->validPayload();

        $response = $this->postJson('/api/customer', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name'         => $payload['name'],
                'email'        => $payload['email'],
                'cpf'          => $payload['cpf'],
                'cep'          => $payload['cep'],
                'street'       => $payload['street'],
                'neighborhood' => $payload['neighborhood'],
                'city'         => $payload['city'],
                'state'        => $payload['state'],
            ]);

        $this->assertDatabaseHas('customers', [
            'email' => $payload['email'],
            'cpf'   => $payload['cpf']
        ]);
    }


    public function test_update_customer()
    {
        $this->authenticate();

        $customer = Customer::factory()->create();

        $updatePayload = $this->validPayload([
            'name'  => 'Dev Alterado',
            'email' => 'dev_alterado@teste.com',
            'cpf'   => '98765432100',
            'cep'   => '63900585',
            'street' => 'Rua Nova',
            'neighborhood' => 'Bairro Novo',
            'city' => 'Cidade Nova',
            'state' => 'SP'
        ]);

        $response = $this->putJson("/api/customer/{$customer->id}", $updatePayload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name'         => 'Dev Alterado',
                'email'        => 'dev_alterado@teste.com',
                'cpf'          => '98765432100',
                'street'       => 'Rua Nova',
                'neighborhood' => 'Bairro Novo',
                'city'         => 'Cidade Nova',
                'state'        => 'SP',
            ]);

        $this->assertDatabaseHas('customers', [
            'id'    => $customer->id,
            'email' => $updatePayload['email'],
            'name'  => $updatePayload['name']
        ]);
    }


    public function test_delete_customer()
    {
        $this->authenticate();

        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customer/{$customer->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id
        ]);
    }

    public function test_get_all_customer()
    {
        $this->authenticate();

        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customer');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_get_by_id_customer()
    {
        $this->authenticate();

        $customer = Customer::factory()->create();

        $response = $this->getJson("/api/customer/{$customer->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id'    => $customer->id,
                'email' => $customer->email
            ]);
    }
}
