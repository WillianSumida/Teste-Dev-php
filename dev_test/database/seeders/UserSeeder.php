<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Teste do Dev',
            'email' => 'teste_dev@teste.com',
            'password' => bcrypt('senhadev')
        ]);
    }
}
