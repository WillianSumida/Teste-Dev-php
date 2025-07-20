<?php

namespace App\Repositories\Customers;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 15)
    {
        $query = Customer::query();

        $query->filter($filters);

        return $query->paginate($perPage);
    }


    public function getById(int $id)
    {
        return Customer::find($id);
    }

    public function create(array $data)
    {
        $customer = Customer::create($data);
        return $customer;
    }

    public function update(int $id, array $data)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->update($data);
            return $customer;
        }
        return null;
    }

    public function delete(int $id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            return $customer->delete();
        }
        return false;
    }
}
