<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll(Request $request): JsonResponse
    {
        $filters = $request->only(['name', 'cpf', 'cep']);
        $perPage = (int) $request->get('per_page', 15);

        $customers = $this->customerRepository->getAll($filters, $perPage);

        return response()->json($customers);
    }

    public function getById($id): JsonResponse
    {
        try {
            $customer = $this->customerRepository->getById($id);
            if (!$customer) {
                return response()->json(['message' => 'Cliente não encontrado.'], 404);
            }
            return response()->json($customer);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao buscar cliente.'], 500);
        }
    }

    public function create(CreateCustomerRequest $request)
    {
        try {
            $customer = $this->customerRepository->create($request->validated());
            return response()->json($customer, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao criar cliente.'], 500);
        }
    }

    public function update(UpdateCustomerRequest $request, $id): JsonResponse
    {
        try {
            $customer = $this->customerRepository->update($id, $request->validated());
            if (!$customer) {
                return response()->json(['message' => 'Cliente não encontrado.'], 404);
            }
            return response()->json($customer);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar cliente.'], 500);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $deleted = $this->customerRepository->delete($id);
            if (!$deleted) {
                return response()->json(['message' => 'Cliente não encontrado.'], 404);
            }
            return response()->json(['message' => 'Cliente removido com sucesso.'], 204);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao deletar cliente.'], 500);
        }
    }
}
