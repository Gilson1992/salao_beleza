<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => Role::Admin,
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'role' => Role::Manager,
            ],
            [
                'name' => 'Professional',
                'email' => 'professional@example.com',
                'role' => Role::Professional,
            ],
            [
                'name' => 'Receptionist',
                'email' => 'receptionist@example.com',
                'role' => Role::Receptionist,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => $user['role'],
                ]
            );
        }
    }
}
