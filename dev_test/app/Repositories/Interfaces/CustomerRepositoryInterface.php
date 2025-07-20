<?php
namespace App\Repositories\Interfaces;

interface CustomerRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 15);
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
