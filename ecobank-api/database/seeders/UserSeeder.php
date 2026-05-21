<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ecobank.ci'],
            [
                'name'     => 'Admin Ecobank',
                'password' => 'password123',
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'employe@ecobank.ci'],
            [
                'name'     => 'Employe Ecobank',
                'password' => 'password123',
                'role'     => 'employe',
            ]
        );
    }
}
