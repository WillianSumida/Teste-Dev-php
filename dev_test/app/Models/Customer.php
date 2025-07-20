<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'phone',
        'cep',
        'street',
        'neighborhood',
        'city',
        'state',
    ];

    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if (empty($value)) continue;

            // Use o like para campos de string, como nome
            if (in_array($key, ['name'])) {
                $query->where($key, 'like', '%' . $value . '%');
            }
            // Exatamente igual para campos como CPF e CEP
            elseif (in_array($key, ['cpf', 'cep'])) {
                $query->where($key, $value);
            }
        }
        return $query;
    }
}
