<?php

namespace App\Http\Requests\Customer;

use App\Rules\Customer\ValidateCep;
use App\Rules\Customer\ValidateCpf;
use App\Rules\Customer\ValidateState;
use App\Services\CepService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'cpf'   => preg_replace('/\D/', '', $this->cpf),
            'phone' => preg_replace('/\D/', '', $this->phone),
            'cep'   => preg_replace('/\D/', '', $this->cep),
            'state' => strtoupper($this->state),
            'name'  => $this->formatName($this->name),
        ]);
    }

    private function formatName(?string $name): string
    {
        return ucwords(mb_strtolower(trim($name ?? '')));
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:customers,email',
            'cpf'          => ['required', 'string', 'size:11', 'unique:customers,cpf', 'bail', new ValidateCpf()],
            'phone'        => 'nullable|string|min:10|max:20',
            'cep'          => ['required', 'digits:8', 'bail', new ValidateCep(app(CepService::class))],
            'street'       => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city'         => 'required|string|max:255',
            'state'        => ['bail', 'required', 'string', 'size:2', "regex:/^[A-Z]{2}$/", new ValidateState()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'O nome é obrigatório.',
            'email.required'        => 'O email é obrigatório.',
            'email.email'           => 'Formato de email inválido.',
            'email.unique'          => 'Este email já está em uso.',
            'cpf.required'          => 'O CPF é obrigatório.',
            'cpf.size'              => 'O CPF deve conter 11 dígitos.',
            'cpf.unique'            => 'Este CPF já está em uso.',
            'cep.required'          => 'O CEP é obrigatório.',
            'cep.digits'            => 'O CEP deve conter exatamente 8 dígitos.',
            'phone.min'             => 'O telefone deve conter no mínimo 10 dígitos.',
            'phone.max'             => 'O telefone excede o limite de caracteres.',
            'street.required'       => 'A rua é obrigatória.',
            'neighborhood.required' => 'O bairro é obrigatório.',
            'city.required'         => 'A cidade é obrigatória.',
            'state.required'        => 'O estado é obrigatório.',
            'state.size'            => 'O estado deve conter exatamente 2 letras.',
            'state.regex'           => 'O estado deve conter apenas 2 letras, sem números.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erro na validação dos dados.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
