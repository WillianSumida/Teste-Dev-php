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
}
